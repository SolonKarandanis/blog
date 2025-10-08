<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::published()
            ->with(['author'])
            ->limit(3)
            ->get();
        return view('posts.index',[
            'posts' => $posts
        ]);
    }
}
