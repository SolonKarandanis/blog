<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    #[Url()]
    public $sort='desc';

    public $search='';

    #[Url()]
    public $category='';

    #[Url()]
    public $popular = false;

    public function setSort($value){
        $this->sort=($value === 'desc')?'desc':'asc';
        $this->resetPage();
    }

    #[On('search')]
    public function updateSearch($search){
        $this->search=$search;
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->resetPage();
    }

    #[Computed()]
    public function posts(){
        $posts=Post::query()
            ->published()
            ->withCount('likes')
            ->withExists(['likes as is_post_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->when($this->activeCategory,function($query){
                return $query->withCategory($this->category);
            })
            ->where('title', 'like', '%'.$this->search.'%')
            ->orderBy('published_at', $this->sort)
            ->with(['author','categories'])
            ->paginate(5);
        return $posts;
    }

    #[Computed()]
    public function activeCategory()
    {
        if ($this->category === null || $this->category === '') {
            return null;
        }

        return Category::where('slug', $this->category)->first();
    }

    public function render()
    {

        return view('livewire.post-list');
    }
}
