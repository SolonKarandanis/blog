<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPosts = Post::featured()
            ->published()
            ->latest('published_at')
            ->limit(3)
            ->get();
        $latestPosts = Post::published()
            ->latest('published_at')
            ->limit(9)
            ->get();

        return view('home',[
            'featuredPosts' => $featuredPosts,
            'latestPosts' => $latestPosts
        ]);
    }
}
