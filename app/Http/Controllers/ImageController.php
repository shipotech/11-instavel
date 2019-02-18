<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            $extension = $image_path->getClientOriginalExtension();
            $filename = uniqid('', true) . '_' . time() . '.' . $extension;

            // Save the new photo on disk
            Storage::disk('images')->put($filename, File::get($image_path));

            // Update with the new photo
            $image->image_path = $filename;
            $image->save();
        }

        return redirect()->route('home')->with([
            'message' => 'You upload the image successfully'
        ]);
    }

    public function show($id)
    {
        $image = Image::find($id);

        return view('image.show', [
            'image'     => $image
        ]);
    }
}
