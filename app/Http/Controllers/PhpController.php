<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhpController extends Controller
{
    public function index()
    {
        phpinfo();
    }
}
