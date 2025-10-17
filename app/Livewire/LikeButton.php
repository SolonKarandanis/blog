<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class LikeButton extends Component
{

    #[Reactive]
    public Post $post;

    public bool $is_post_liked;

    public function mount(Post $post){
        $this->post = $post;
        $this->is_post_liked = $post->is_post_liked;
    }

    public function toggleLike()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        if($user->hasLiked($this->post)){
            $user->likes()->detach($this->post->id);
            $this->is_post_liked = false;
        }
        else{
            $user->likes()->attach($this->post->id);
            $this->is_post_liked = true;
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
