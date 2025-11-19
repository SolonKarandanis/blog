<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public Post $post;

    public function mount(Post $post){
        $this->post = $post;
    }

    #[On('commentCreated')]
    #[On('commentDeleted')]
    #[On('commentUpdated')]
    public function forceRefresh()
    {
        // This will re-render the component
    }

    public function comments(){
        return Comment::query()
            ->where('post_id', $this->post->id)
            ->whereNull('parent_id')
            ->with(['user','childComments','childComments.user'])
            ->orderByDesc('created_at')
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->comments()
        ]);
    }
}
