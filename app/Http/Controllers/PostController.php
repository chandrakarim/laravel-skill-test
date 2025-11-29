<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_draft', false)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->with('user')
            ->paginate(100);

        // $post = Post::all();

        return response()->json($posts);
    }

    public function show(Post $post)
    {
        if ($post->is_draft || ($post->published_at && $post->published_at->isFuture())) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post->load('user'));
    }

    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->validated());

        return response()->json($post, 201);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->update($request->validated());

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}
