<?php

namespace App\Http\Controllers;


use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        return view('posts.index');
    }

    public function show(Post $post){
        return view('posts.show',[
            'post'=>$post
        ]);
    }
}
