<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    #[Url()]
    public $sort='desc';

    public function setSort($value){
        $this->sort=($value === 'desc')?'desc':'asc';
    }
    #[Computed()]
    public function posts(){
        return Post::published()
            ->orderBy('published_at', $this->sort)
            ->with(['author'])
            ->paginate(5);
    }
    public function render()
    {

        return view('livewire.post-list');
    }
}
