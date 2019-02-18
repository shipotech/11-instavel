<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function config()
    {
        return view('user.config');
    }

    public function updatePersonal(Request $request)
    {
        // Validate the form
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
        ]);

        // Obtain values from form
        $name = $request->input('name');
        $surname = $request->input('surname');

        // Assign new values to the user Object
        $user = \Auth::user();
        $user->name = $name;
        $user->surname = $surname;

        // Excute Update in the DB
        $user->update();

        return redirect()->back()->with([
            'message' => 'You updated successfully your info'
        ]);
    }

    public function updateLogin(Request $request)
    {
        // Obtain Current User
        $user = \Auth::user();
        $id = $user->id;

        // Validate the form
        $validate = $this->validate($request, [
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id]
        ]);

        // Obtain values from form
        $nick = $request->input('nick');
        $email = $request->input('email');

        // Assign new values to the user Object
        $user->nick = $nick;
        $user->email = $email;

        // Excute Update in the DB
        $user->update();

        return redirect()->back()->with([
            'message' => 'You updated successfully your info'
        ]);
    }

    public function updatePassword(Request $request)
    {
        // Validate the form
        $validate = $this->validate($request, [
            'password' => ['required', 'string', 'min:6', 'max:20','confirmed'],
        ]);

        // Obtain values from form
        $password = \Hash::make($request->input('password'));

        // Assign new values to the user Object
        $user = \Auth::user();
        $user->password = $password;

        // Excute Update in the DB
        $user->update();

        return redirect()->back()->with([
            'message' => 'You updated successfully your info'
        ]);
    }
}
