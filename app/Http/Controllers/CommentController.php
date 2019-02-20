<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Middleware
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        // Obtain data
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // Validate the form data
        $validate = $this->validate($request, [
            'image_id'  => 'integer|required',
            'content'   => 'string|required'
        ]);

        // Assign values
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        // Store the new comment
        $comment->save();

        return redirect()->route('image.show', ['id' => $image_id])->with([
            'message' => 'Your comment has been added successfully'
        ]);
    }

    public function delete($id)
    {
        // Obtain comment data
        $user = \Auth::user();
        $comment = Comment::find($id);

        // If user are logged and this user are the same that is logged, or this Image belongs to this user:
        // Can delete the comment
        if ($user && ($comment->user_id === $user->id || $comment->image->user_id === $user->id)) {
            $comment->delete();

            return redirect()->route('image.show', ['id' => $comment->image->id])->with([
                'message' => 'Comment delete successfully'
            ]);
        }

        // If something fails, error message
        return redirect()->route('image.show', ['id' => $comment->image->id])->with([
            'error' => "Something goes wrong, your comment can't be delete"
        ]);
    }
}