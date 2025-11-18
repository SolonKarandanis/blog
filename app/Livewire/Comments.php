<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public Post $post;

    protected $listeners = [
        'commentCreated' => '$refresh',
        'commentDeleted' => '$refresh',
    ];

    public function mount(Post $post){
        $this->post = $post;
    }

    #[Computed()]
    public function comments(){
        return Comment::query()
            ->where('post_id', $this->post->id)
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
