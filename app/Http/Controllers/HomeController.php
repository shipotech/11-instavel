<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

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
        $images = Image::orderBy('id', 'DESC')->paginate(5);


        return view('home', [
            'images' => $images
        ]);
    }

    public function darkMode()
    {
        if (session()->has('isDark')) {
            session()->put('isDark', !session('isDark'));
        } else {
            //provide an initial value of isDark
            session()->put('isDark', true);
        }

        return redirect()->back();
    }
}
