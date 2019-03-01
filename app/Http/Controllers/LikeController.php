<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like(Request $request)
    {
        // Obtain the user data and the Image
        $user = \Auth::user();
        $image_id = $request->message;

        $isset_like = Like::where('user_id', $user->id)
            ->where('image_id', $image_id)
            ->count();

        if ($isset_like === 0) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = $image_id;

            // Store the data
            $like->save();

            $likes = Like::where('image_id', $image_id)->count();
            return response()->json([
                'fail'      => false,
                'likes'     => $likes
            ]);
        }

        $likes = Like::where('image_id', $image_id)->count();

        return response()->json([
            'fail'      => true,
            'likes'     => $likes
        ]);
    }

    public function dislike(Request $request)
    {
        // Obtain the user data and the Image
        $user = \Auth::user();
        $image_id = $request->message;

        $like = Like::where('user_id', $user->id)
            ->where('image_id', $image_id)
            ->first();

        if ($like) {
            // Delete like
            $like->delete();

            $likes = Like::where('image_id', $image_id)->count();
            return response()->json([
                'fail'      => false,
                'likes'     => $likes
            ]);
        }

        $likes = Like::where('image_id', $image_id)->count();
        return response()->json([
            'fail'      => true,
            'likes'     => $likes
        ]);
    }

    public function show(Request $request)
    {
        $image_id = $request->message;

        $likes = Like::where('image_id', $image_id)->orderBy('id', 'desc')->get();

        return view('like.show')->with('likes', $likes);
    }
}
