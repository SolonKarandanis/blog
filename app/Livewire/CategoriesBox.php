<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CategoriesBox extends Component
{

    #[Computed()]
    public function categories(){
        return Category::query()
            ->whereHas('posts',function($query){
                $query->published();
            })
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.categories-box');
    }
}
