@props(['post'])
<div {{$attributes}}>
    <a wire:navigate href="{{route('posts.show',$post->slug)}}">
        <div>
            <img class="w-full rounded-xl"
                 src="{{$post->getThumbnailImage()}}" alt="thumbnail">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2 gap-x-2">
            @foreach($post->categories as $category)
                <x-posts.category-badge :category="$category" />
            @endforeach
            <p class="text-gray-500 text-sm">{{$post->published_at}}</p>
        </div>
        <a wire:navigate href="{{route('posts.show',$post->slug)}}" class="text-xl font-bold text-gray-900 dark:text-gray-200">
            {{$post->title}}
        </a>
    </div>
</div>
