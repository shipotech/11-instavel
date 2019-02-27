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
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $images = Image::orderBy('id', 'DESC')->paginate(5);

        if ($request->ajax()) {
            return view('layouts.show-more')->with('images', $images);
        }

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
