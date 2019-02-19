<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        $filename = uniqid('', true) . '_' . time() . '.' . $extension;

        // Delete previous profile photo if the user has one on DB
        if ($user->image !== null || !empty($user->image)) {
            Storage::disk('users')->delete($user->image);
        }

        // Save the new photo
        Storage::disk('users')->put($filename, File::get($image));

        // Update with the new photo
        $user->image = $filename;
        $user->update();

        return $filename;
    }

    // Method for Upload images in Home
    public function store(Request $request)
    {
        // Obtain data
        $description = $request->input('description');
        $image_path = $request->file('upload');

        // Validation
        $validate = $this->validate($request, [
           'description'    => 'required',
           'upload'         => 'required|mimes:jpeg,jpg,png,gif'
        ]);

        // Assign values
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->image_path = null;
        $image->description = $description;

        // Upload the image
        if ($image_path) {

            //filename to store
            $extension = $image_path->getClientOriginalExtension();
            $filename = uniqid('', true) . '_' . time() . '.' . $extension;

            // Save the new Image on disk
            Storage::disk('images')->put($filename, File::get($image_path));

            // Obtain the new ubication of the Image
            $saveImage = public_path('storage/images/'.$filename);

            // Obtain the dimension
            $height = Intervention::make($saveImage)->height();
            $width = Intervention::make($saveImage)->width();

            // Fill the images that don't fit the condition's below:
            if ($width < 665 && $height < 450) {
                // create an Instance
                $img = Intervention::make($saveImage);

                // set a background-color for the emerging area
                $img->resizeCanvas(665, 450, 'center', false, '212121');
            } elseif ($width < 665) {
                // create empty canvas
                $img = Intervention::make($saveImage);

                // set a background-color for the emerging area
                $img->resizeCanvas(665, $height, 'center', false, '212121');
            } elseif ($height < 450) {
                // create empty canvas
                $img = Intervention::make($saveImage);

                // set a background-color for the emerging area
                $img->resizeCanvas($width, 450, 'center', false, '212121');
            } else {
                //Resize image here
                $img = Intervention::make($saveImage)->resize(665, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $img->save($saveImage);

            // Update with the new photo
            $image->image_path = $filename;
            $image->save();

        }

        return redirect()->route('home')->with([
            'message'   => 'You upload the image successfully'
        ]);
    }

    // Method for show (one) uploaded image
    public function show($id)
    {
        $image = Image::find($id);

        return view('image.show', [
            'image'     => $image
        ]);
    }
}
