<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Image;
use App\Like;
use App\User;
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
        $user->name = strtolower($name);
        $user->surname = strtolower($surname);

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
        $user->nick = strtolower($nick);
        $user->email = strtolower($email);

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

    public function profile(Request $request)
    {
        $id = $request->id;

        $images = Image::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        if ($request->ajax()) {
            return view('user.show-more')->with('images', $images);
        }

        $user = User::find($id);

        $likes = Like::with('user')
            ->where('user_id', $id)
            ->count();

        $comments = Comment::with('user')
            ->where('user_id', $id)
            ->count();

        $publications = Image::with('user')
            ->where('user_id', $id)
            ->count();

        return view('user.profile', [
            'user'          => $user,
            'images'        => $images,
            'likes'         => $likes,
            'comments'      => $comments,
            'publications'  => $publications
        ]);
    }

    public function ajaxMore()
    {
        $images = Image::orderBy('id', 'DESC')->paginate(5);

        return view('like.show')->with('likes', $likes);
    }
}
