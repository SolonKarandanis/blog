<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public Post $post;

    #[Rule('required|min:3|max:200')]
    public string $comment;

    public function mount(Post $post){
        $this->post = $post;
    }

    public function postComment()
    {
        if (auth()->guest()) {
            return;
        }

        $this->validateOnly('comment');

        Comment::create([
            'body' => $this->comment,
            'user_id' => auth()->id(),
            'post_id' => $this->post->id,
        ]);

        $this->reset('comment');
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
        return view('livewire.comments');
    }
}
