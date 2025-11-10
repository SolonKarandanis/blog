<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index');
    }

    public function show(string $slug, Request $request){
        $post = Post::query()
            ->where('slug', $slug)
            ->withCount('likes')
            ->withExists(['likes as is_post_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->with(['author', 'categories'])
            ->firstOrFail();

        $user= $request->user();
        PostView::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => $user?->id,
            'post_id' => $post->id,
        ]);
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
