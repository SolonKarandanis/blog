<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPosts =Cache::remember('featuredPosts', Carbon::now()->addMinutes(30), function () {
            return Post::query()
                ->featured()
                ->published()
                ->with(['categories'])
                ->latest('published_at')
                ->limit(3)
                ->get();
        });
        $latestPosts =Cache::remember('latestPosts', Carbon::now()->addMinutes(30), function (){
            return Post::query()
                ->published()
                ->with(['categories'])
                ->latest('published_at')
                ->limit(9)
                ->get();
        });

        $popularPosts= Cache::remember('popularPosts', Carbon::now()->addMinutes(30), function (){
            return Post::query()
                ->leftJoin('post_like', 'posts.id', '=', 'post_like.post_id')
                ->select('posts.*',DB::raw('count(post_like.post_id) as like_count'))
                ->published()
                ->orderByDesc('like_count')
                ->groupBy([
                    'posts.id',
                    'posts.user_id',
                    'posts.image',
                    'posts.title',
                    'posts.slug',
                    'posts.body',
                ])
                ->latest('published_at')
                ->limit(5)
                ->get();
        });

        return view('home',[
            'featuredPosts' => $featuredPosts,
            'latestPosts' => $latestPosts,
            'popularPosts' => $popularPosts,
        ]);
    }
}
