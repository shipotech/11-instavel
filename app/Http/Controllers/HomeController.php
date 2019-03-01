<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $images = Image::orderBy('id', 'DESC')->skip(0)->take(5)->get();

        // form token
        $form_token = uniqid('', true);
        // Hashing uniqid
        $form_token = Hash::make($form_token);
        // create form token session and store generated id in it.
        session(['form_token' => $form_token]);

        return view('home', [
            'images' => $images
        ]);
    }

    public function scroll(Request $request)
    {
        $lastId = $request->message;

        $images = Image::where('id', '<', $lastId)->orderBy('id', 'DESC')->take(5)->get();

        if ($request->ajax()) {
            if (\count($images) > 0) {
                foreach ($images as $image) {
                    $lastId = $image->id;
                }

                // return a view ready to ".append" in jquery, and other data
                return response()->json([
                    'view'   => view('layouts.show-more')->with('images', $images)->render(),
                    'last'   => $lastId,
                    'status' => true
                ]);
            }

            return response()->json([
                'status'   => false
            ]);
        }
        abort(403);
    }

    // Change Theme Color to Dark or Light
    public function darkMode()
    {
        if (session('isDark')) {
            session(['isDark' => false]);
        } else {
            //provide an initial value of isDark
            session(['isDark' => true]);
        }

        return redirect()->back();
    }
}
