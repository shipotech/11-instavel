<?php

namespace App\Http\Controllers;

use App\Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Intervention;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

            $contents = collect(Storage::disk('users')->listContents('/', false));

            $file = $contents->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($user->image, PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($user->image, PATHINFO_EXTENSION))
                ->first(); // there can be duplicate file names!

            Storage::disk('users')->delete($file['path']);

        // Save the new photo
        $image->move(public_path('storage/users/'), $filename);

        // Obtain the new local ubication
        $saveImage = public_path('storage/users/' . $filename);

        // New instance
        $img = Intervention::make($saveImage);

        //Resize image here
        // prevent possible upsizing
        $img->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Save the resize Image in local folder (public/storage/users/)
        $img->save($saveImage);

        // Save the new Image in Google Drive
        Storage::disk('users')->put($filename, File::get($saveImage));

        // Update the database with the new photo
        $user->image = Storage::disk('users')->url($filename);

        if (!$user->image) {
            $user->image = 'https://i.ibb.co/2kjt747/nouser.png';
        }

        $user->update();
        File::delete($saveImage);

        return $user->image;
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
            Storage::disk('images')->put($filename, File::get($saveImage));

            // Update the database with the new Image
            $image->image_path = Storage::disk('images')->url($filename);
            $image->save();
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
}
