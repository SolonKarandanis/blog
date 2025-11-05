<div >
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-3">{{__('blog.recommended_topics')}}</h3>
    <div class="topics flex flex-wrap justify-start gap-3">
        @foreach($this->categories as $category)
            <x-badge wire:navigate href="{{route('posts.index',['category'=>$category->slug])}}"
                     textColor="{{$category->text_color}}"
                     bgColor="{{$category->bg_color}}" >
                {{$category->slug}}
            </x-badge>
        @endforeach
    </div>
</div>
