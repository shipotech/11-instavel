<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
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

            try {
                $this->drive->files->delete($user->drive_id);
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
        if ($image_path && $image_path !== null) {
            // Assign values
            $user = \Auth::user();
            $image = new Image();
            $image->user_id = $user->id;
            $image->description = $description;

            //filename to store
            $extension = $image_path->getClientOriginalExtension();
            $filename = (Image::count() + 1) . '_' . uniqid('', true) . '_' . time() . '.' . $extension;

            // Handler file (resize image and upload it on Google Drive)
            $file_id = $this->fileHandler($image_path, $filename);

            // Update the database with the new Images
            $image->drive_id1 = $file_id[0];
            $image->drive_id2 = $file_id[1];
            $image->drive_id3 = $file_id[2];
            $image->drive_id4 = $file_id[3];
            $image->image_path = $filename;
            $image->save();

            return redirect()->route('home')->with([
                'message'   => 'Image uploaded successfully'
            ]);
        }

        return redirect()->route('home')->with([
            'errors'   => 'Something goes wrong. Please, refresh and try again'
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

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $user = \Auth::user();
            $image = Image::find($request->id);

            if ($user && $image && $image->user->id === $user->id) {
                return response()->json([
                    'view' => view('image.edit')->with('image', $image)->render(),
                    'status' => true
                ]);
            }
            return response()->json([
                'status' => false
            ]);
        }
        abort(403);
    }

    public function update(Request $request)
    {
        // Check if the user has submit the form multiple times
        $form_token = $request->input('form_token');

        if ($form_token !== session('form_token')) {
            return redirect()->route('home')->with([
                'image-message' => 'Please, wait a moment or refresh this page',
                'alert-color'   => 'danger',
                'title'         => 'Whoops!'
            ]);
        }
        // -----------------------------------------------------

        // Obtain data
        $image_id = $request->input('image_id');
        $image_path = $request->file('upload');
        $description = $request->input('description');

        // Validation
        $validate = $this->validate($request, [
            'description' => 'required',
            'upload'      => 'mimes:jpeg,jpg,png'
        ]);

        // Assign values
        $user = \Auth::user();
        // Obtain previous
        $image = Image::find($image_id);
        $image->user_id = $user->id;
        $image->description = $description;

        // Upload the image
        if ($image_path && $image_path !== null) {

            //filename to store
            $extension = $image_path->getClientOriginalExtension();
            $filename = (Image::count() + 1) . '_' . uniqid('', true) . '_' . time() . '.' . $extension;

            try {
                if ($image->drive_id1 !== null) {
                    // Deleting previous Images on Google Drive
                    $this->drive->files->delete($image->drive_id1);
                    $this->drive->files->delete($image->drive_id2);
                    $this->drive->files->delete($image->drive_id3);
                    $this->drive->files->delete($image->drive_id4);
                }

                // Handler file (resize image and upload it on Google Drive)
                $file_id = $this->fileHandler($image_path, $filename);

                // Update the database with the new Images
                $image->drive_id1 = $file_id[0];
                $image->drive_id2 = $file_id[1];
                $image->drive_id3 = $file_id[2];
                $image->drive_id4 = $file_id[3];
                $image->image_path = $filename;
                $image->update();

                $message = [
                    'image-message' => 'Image edited successfully',
                    'alert-color'   => 'success',
                    'title'         => 'Success!'
                ];

            } catch (Exception $e) {
                $message = [
                    'image-message' => 'There was a problem uploading the new image',
                    'alert-color'   => 'danger',
                    'title'         => 'Whoops!'
                ];
            }
            return redirect()->back()->with($message);
        }

        if ($image_path === null) {

            $image->update();
            $message = [
                'image-message' => 'Image edited successfully',
                'alert-color'   => 'success',
                'title'         => 'Success!'
            ];

            return redirect()->back()->with($message);
        }

        $message = [
            'image-message' => 'There was a problem uploading the new image',
            'alert-color'   => 'danger',
            'title'         => 'Whoops!'
        ];
        return redirect()->back()->with($message);
    }

    public function delete($id)
    {
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if ($user && $image && $image->user->id === $user->id) {
            // Deleting the comments
            if ($comments && \count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            // Deleting the likes
            if ($likes && \count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            // Deleting the image

            try {
                if ($image->drive_id1 !== null) {
                    $this->drive->files->delete($image->drive_id1);
                    $this->drive->files->delete($image->drive_id2);
                    $this->drive->files->delete($image->drive_id3);
                    $this->drive->files->delete($image->drive_id4);
                }
                $image->delete();

                $message = [
                    'image-message' => 'Image deleted successfully',
                    'alert-color'   => 'success',
                    'title'         => 'Success!'
                ];
            } catch (Exception $e) {
                $message = [
                    'image-message' => 'There was a problem with Google Drive, please contact the admin',
                    'alert-color'   => 'danger',
                    'tittle'        => 'Whoops!'
                ];
            }

        } else {
            $message = [
                'image-message' => 'There was a problem with your request, please try again in a few seconds',
                'alert-color'   => 'warning',
                'tittle'        => 'Whoops!'
            ];
        }
        return redirect()->back()->with($message);
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

    // Methods for Manage Files on Google Drive
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

    // Methods for Manage Files on Google Drive
    public function fileHandler($image_path, $filename)
    {
        // Save the new Image on disk
        $image_path->move(public_path('storage/images/'), $filename);

        // Obtain the new ubication of the Image
        $saveImage = public_path('storage/images/'.$filename);

        // create an Instance
        $img = Intervention::make($saveImage);

        $large_photos_storage = public_path('storage/images/large/');
        $medium_photos_storage = public_path('storage/images/medium/');
        $mobile_photos_storage = public_path('storage/images/mobile/');
        $tiny_photos_storage = public_path('storage/images/tiny/');

        // Processing the new Image and resize it
        $img->resize(860, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($large_photos_storage . $filename, 85)
            ->resize(640, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($medium_photos_storage . $filename, 85)
            ->resize(420, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($mobile_photos_storage . $filename, 85)
            ->resize(50, null, function ($constraint) {
                $constraint->aspectRatio();
            })->blur(1)->save($tiny_photos_storage . $filename, 85);

        // Original Images stored on temporal path's
        $image_size = array(
            $large_photos_storage.$filename,
            $medium_photos_storage.$filename,
            $mobile_photos_storage.$filename,
            $tiny_photos_storage.$filename
        );

        // Google Drive Path's
        $google_path = array(
            env('GOOGLE_FOLDER_LARGE_IMAGES'),
            env('GOOGLE_FOLDER_MEDIUM_IMAGES'),
            env('GOOGLE_FOLDER_MOBILE_IMAGES'),
            env('GOOGLE_FOLDER_TINY_IMAGES')
        );

        // Creating the images in their respectively path's on Google Drive
        $file_id = array(); // Arreglar Edit de imagenes
        for ($i = 0; $i <= 3; $i++) {
            $file = File::get($image_size[$i]);
            $mimeType = File::mimeType($image_size[$i]);
            $file_id[$i] = $this->createFile($file, $mimeType, $filename, $google_path[$i]);

            // Delete the image in temporal path
            File::delete($saveImage);
            File::delete($image_size[$i]);
        }

        return $file_id;
    }

}
