<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        return Post::with('user', 'comments.user')->get();
    }

    public function store(Request $request) {
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = '1';

        $post->save();

        return response()->json([
            'post' => $post,
            'message' => 'Post created', 
            'method' => 'POST'], 
        201);
    }

    public function show(Post $post) {
        return response()->json($post->load('user', 'comments.user'));
    }

    public function update(Request $request, Post $post) {
        //$this->authorize('update', $post);

        $request->validate([
            'title' => 'string',
            'content' => 'string',
        ]);

        //$post->update($request->only(['title', 'content']));
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return response()->json($post->load('user', 'comments.user'));
    }

    public function destroy(Post $post) {
       // $this->authorize('delete', $post);

        $post->delete();

        return response()->json(null, 204);
    }
}
