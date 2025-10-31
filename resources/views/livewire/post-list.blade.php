<div class=" px-3 lg:px-7 py-6">
    <div class="border-b border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <div>
                @if ($this->activeCategory || $search)
                    <button class="mr-3 text-xs text-gray-900 dark:text-gray-100" wire:click="clearFilters()">X</button>
                @endif
                @if ($this->activeCategory)
                    <x-badge wire:navigate href="{{ route('posts.index', ['category' => $this->activeCategory->slug]) }}"
                             :textColor="$this->activeCategory->text_color" :bgColor="$this->activeCategory->bg_color">
                        {{ $this->activeCategory->title }}
                    </x-badge>
                @endif
                @if($search)
                    <span class="text-gray-900 dark:text-gray-100 font-bold">Searching '{{$search}}'</span>
                @endif
            </div>
            <div class="flex items-center space-x-4 font-light">
                <x-checkbox wire:model.live="popular" />
                <x-label>Popular</x-label>
                <button
                    class="{{$sort==='desc'? 'text-gray-900 dark:text-gray-100 border-b border-gray-400':'text-gray-500 dark:text-gray-300'}} py-4"
                    wire:click="setSort('desc')">
                    Latest
                </button>
                <button
                    class="{{$sort==='asc'? 'text-gray-900 dark:text-gray-100 border-b border-gray-400':'text-gray-500 dark:text-gray-300'}} py-4"
                    wire:click="setSort('asc')">
                    Oldest
                </button>
            </div>
        </div>

    </div>
    <div class="py-4">
        @foreach($this->posts as $post)
            <x-posts.post-item :key="$post->id" :post="$post" />
        @endforeach
    </div>
    <div class="my-3">
        {{$this->posts->onEachSide(1)->links()}}
    </div>
</div>
