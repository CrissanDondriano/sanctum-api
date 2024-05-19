<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        return Post::with('user', 'comments')->get();
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($post);
    }

    public function show(Post $post) {
        return response()->json($post->load('user', 'comments'));
    }

    public function update(Request $request, Post $post) {
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'string',
            'content' => 'string',
        ]);

        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy(Post $post) {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(null, 204);
    }
}
