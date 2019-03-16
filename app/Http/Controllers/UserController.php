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

    public function index()
    {
        $users = User::orderBy('id', 'DESC')->skip(0)->take(6)->get();

        return view('user.index', [
            'users' => $users,
            'color' => $this->randomColor()
        ]);
    }

    public function scrollPeople(Request $request)
    {
        $lastId = $request->message;

        $users = User::where('id', '<', $lastId)->orderBy('id', 'DESC')->take(3)->get();

        if ($request->ajax()) {
            if (\count($users) > 0) {
                foreach ($users as $user) {
                    $lastId = $user->id;
                }

                return response()->json([
                    'view'   => view('user.people', [
                        'users' => $users,
                        'color' => $this->randomColor()
                    ])->render(),
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

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $string = strtolower($request->message);
            $users = User::where('nick', 'LIKE', '%' . $string . '%')->get();

            if ($users) {
                return response()->json([
                    'view'   => view('user.search', [
                        'users' => $users
                    ])->render(),
                    'status' => true
                ]);
            }
            return response()->json([
                'status' => false
                ]);
        }

        abort(403);
    }

    public function randomColor(): array
    {
        $colors = [
            'aqua-gradient',
            'purple-gradient',
            'peach-gradient',
            'blue-gradient',
            'rgba-blue-strong',
            'rgba-orange-strong',
            'unique-color',
            'default-color-dark',
            'rgba-blue-grey-strong',
            'rgba-red-strong',
            'light-blue accent-4',
            'deep-purple darken-4',
            'warning-color-dark',
            'danger-color-dark',
            'rgba-yellow-strong'
        ];

        return $colors;
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
        session(['actual_profile' => $id]);

        $images = Image::where('user_id', $id)->orderBy('id', 'DESC')->skip(0)->take(3)->get();

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

    public function scroll(Request $request)
    {
        $lastId = $request->message;
        $user_id = session('actual_profile');

        $images = Image::where('user_id', $user_id)
            ->where('id', '<', $lastId)->orderBy('id', 'DESC')->take(3)->get();

        if ($request->ajax()) {
            if (\count($images) > 0) {
                foreach ($images as $image) {
                    $lastId = $image->id;
                }

                return response()->json([
                    'view'   => view('user.show-more')->with('images', $images)->render(),
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
}