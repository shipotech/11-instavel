<?php

namespace App\Http\Controllers;

use Exception;
use App\Image;
use App\User;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Intervention;

class ImageController extends Controller
{
    private $drive;
    public function __construct(Google_Client $client)
    {
        $this->middleware('auth');

        //* setting refresh token and creating a new instance of  Google_Service_Drive  with Google_Client
        //* instance from service container
        $this->middleware(function ($request, $next) use ($client) {
            $client->refreshToken(env('GOOGLE_REFRESH_TOKEN'));
            $this->drive = new Google_Service_Drive($client);
            return $next($request);
        });
    }

    // Method for profile avatar
    public function ajaxImage(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('user.config');
        }

        $validator = Validator::make($request->all(),
            [ 'file'        => 'required|image' ],
            [ 'file.image'  => 'The file must be an image (jpeg, png, gif)']
        );

        // Obtain current user
        $user = \Auth::user();

        // if have errors, return the errors
        if ($validator->fails()) {
            return array(
                'fail' => true,
                'previous' => $user->image,
                'errors' => $validator->errors(),
            );
        }

        // Obtain the image, extension and create new unique filename
        $image = $request->file('file');
        $extension = $image->getClientOriginalExtension();
        $filename = (\count(User::all()) + 1) . '_' . uniqid('', true) . '_' . time() . '.' . $extension;

        // Delete previous profile photo if the user has one on DB
        if ($user->image !== null || !empty($user->image)) {
            $file_id = $this->findFile(env('GOOGLE_FOLDER_USERS'), $user->image);

            try {
                $this->drive->files->delete($file_id);
            } catch (Exception $e) {
                return array(
                    'fail' => true,
                    'previous' => $user->drive_id,
                    'errors' => [
                        'file' => 'There was a problem with Google Drive, please contact the admin'
                    ]);
            }
        }

        // Save the new photo
        $image->move(public_path('storage/users/'), $filename);

        // Obtain the new local ubication
        $saveImage = public_path('storage/users/' . $filename);

        // New instance
        $img = Intervention::make($saveImage);

        // Resize image here
        // prevent possible upsizing
        $img->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Save the resize Image in local folder (public/storage/users/)
        $img->save($saveImage);

        // Save the new Image in Google Drive
        $file = File::get($saveImage);
        $mimeType = File::mimeType($saveImage);
        $file_id = $this->createFile($file, $mimeType, $filename, env('GOOGLE_FOLDER_USERS'));

        // Update the database with the new photo
        $user->image = $filename;
        $user->drive_id = $file_id;

        if (!$user->image) {
            $user->image = 'https://i.ibb.co/2kjt747/nouser.png';
        }

        $user->update();
        File::delete($saveImage);

        return "https://drive.google.com/uc?id=$user->drive_id&export=media";
    }


    // Method for Upload images in Home
    public function store(Request $request)
    {
        // Check if the user has submit the form multiple times
        $form_token = $request->input('form_token');

        if ($form_token !== session('form_token')) {
            return redirect()->route('home')->with([
                'error'   => 'Please, wait a moment or refresh this page'
            ]);
        }
        // -----------------------------------------------------

        // Obtain data
        $description = $request->input('description');
        $image_path = $request->file('upload');

        // Validation
        $validate = $this->validate($request, [
           'description'    => 'required',
           'upload'         => 'required|mimes:jpeg,jpg,png'
        ]);

        // Upload the image
        if ($image_path) {
            // Assign values
            $user = \Auth::user();
            $image = new Image();
            $image->user_id = $user->id;
            $image->image_path = null;
            $image->description = $description;

            //filename to store
            $extension = $image_path->getClientOriginalExtension();
            $filename = (\count(Image::all()) + 1) . '_' . uniqid('', true) . '_' . time() . '.' . $extension;

            // Save the new Image on disk
            $image_path->move(public_path('storage/images/'), $filename);

            // Obtain the new ubication of the Image
            $saveImage = public_path('storage/images/'.$filename);

            // Obtain the dimension
            $height = Intervention::make($saveImage)->height();
            $width = Intervention::make($saveImage)->width();

            // create an Instance
            $img = Intervention::make($saveImage);

            // Fill the images that don't fit the conditions below:
            if ($width < 665 && $height < 450) {

                // set a background-color for the emerging area
                $img->resizeCanvas(665, 450, 'center', false, '212121');
            } elseif ($width < 665) {

                // set a background-color for the emerging area
                $img->resizeCanvas(665, $height, 'center', false, '212121');
            } elseif ($height < 450) {

                // set a background-color for the emerging area
                $img->resizeCanvas($width, 450, 'center', false, '212121');
            } else {

                //Resize image here
                $img->resize(665, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Save the resize Image in local folder (public/storage/images/)
            $img->save($saveImage);

            // Save the new Image in Google Drive
            $file = File::get($saveImage);
            $mimeType = File::mimeType($saveImage);
            $file_id = $this->createFile($file, $mimeType, $filename, env('GOOGLE_FOLDER_IMAGES'));

            // Update the database with the new Image
            $image->image_path = $filename;
            $image->drive_id = $file_id;
            $image->save();

            // Delete the image in temporal path
            File::delete($saveImage);

            return redirect()->route('home')->with([
                'message'   => 'You upload the image successfully'
            ]);
        }

        return redirect()->route('home')->with([
            'errors'   => 'Something goes wrong...'
        ]);
    }

    // Method for show (one) uploaded image
    public function show($id)
    {
        $image = Image::find($id);

        // form token
        $form_token = uniqid('', true);

        // Hashing uniqid
        $form_token = Hash::make($form_token);

        // create form token session and store generated id in it.
        session(['form_token' => $form_token]);

        return view('image.show', [
            'image'     => $image
        ]);
    }

    // Methods for Manage Files on Google Drive
    public function findFile($folder, $name)
    {
        $query = "name='".$name."' and '".$folder."' in parents and trashed=false";

        $optParams = [
            'q' => $query,
            'fields' => 'files(id, name)'
        ];

        $results = $this->drive->files->listFiles($optParams)->getFiles();

        if (\is_array($results) && empty($results)) {
            return null;
        }

        return $results[0]['id'];
    }

    public function createFile($content, $mimeType, $name, $parent_id){
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $name,
            'parents' => array($parent_id)
        ]);

        $file = $this->drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return $file->id;
    }
}
