<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPosts =Cache::remember('featuredPosts', Carbon::now()->addMinutes(30), function () {
            return Post::featured()
                ->published()
                ->with(['categories'])
                ->latest('published_at')
                ->limit(3)
                ->get();
        });
        $latestPosts =Cache::remember('latestPosts', Carbon::now()->addMinutes(30), function (){
            return Post::published()
                ->with(['categories'])
                ->latest('published_at')
                ->limit(9)
                ->get();
        });

        return view('home',[
            'featuredPosts' => $featuredPosts,
            'latestPosts' => $latestPosts
        ]);
    }
}
