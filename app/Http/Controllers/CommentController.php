<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index() {
        return Comment::with('user')->get();
    }

    public function store(Request $request) {
        $request->validate([
            'post_id' => 'required',
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->user_id = '1';
        $comment->content = $request->content;
        $comment->save();

        return response()->json($comment->load('user'));
    }

    public function show(Comment $comment) {
        return response()->json($comment->load('user'));
    }

    public function update(Request $request, Comment $comment) {
       // $this->authorize('update', $comment);

        $request->validate([
            'content' => 'string',
        ]);

       // $comment->update($request->only(['content']));
        $comment->content = $request->content;
        $comment->save();

        return response()->json($comment->load('user'));
    }

    public function destroy(Comment $comment) {
        //$this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 204);
    }
}
