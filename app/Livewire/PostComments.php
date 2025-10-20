<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PostComments extends Component
{
    public Post $post;

    public function mount(Post $post){
        $this->post = $post;
    }

    #[Computed()]
    public function comments(){
        return Comment::query()
            ->where('post_id', $this->post->id)
            ->orderByDesc('created_at')
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.post-comments');
    }
}
