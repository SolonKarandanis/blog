<?php

namespace App\Http\Controllers;


use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        return view('posts.index');
    }

    public function show(string $slug){
        $post = Post::query()
            ->where('slug', $slug)
            ->withCount('likes')
            ->withExists(['likes as is_post_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->with(['author','categories'])
            ->firstOrFail();
        return view('posts.show',[
            'post'=>$post
        ]);
    }
}
