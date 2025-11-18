<div class="mt-10 comments-box border-t border-gray-100 pt-10">
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-200 mb-5">Discussions</h2>
    @auth
        <div x-data="{
            focused:false
        }">
            <textarea
                @click="focused = true"
                wire:model="comment"
                class="w-full rounded-lg p-4 bg-gray-50 dark:bg-gray-600 focus:outline-none text-sm text-gray-900 dark:text-gray-200 border-gray-200 placeholder:text-gray-400"
                cols="30"
                :rows="focused ? '7': '1'"></textarea>
            <div :class="focused ? '':'hidden'">
                <button
                    wire:click="postComment"
                    class="mt-3 inline-flex items-center justify-center h-10 px-4 font-medium tracking-wide text-white transition duration-200 bg-gray-700 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                    Post Comment
                </button>
            </div>
        </div>
    @else
        <a wire:navigate class="text-yellow-500 underline py-1" href="{{route('login')}}"> Login to Post Comments</a>
    @endauth

    <div class="px-3 py-2 mt-5 user-comments">
        @forelse($this->comments as $comment)
            <livewire:comment-item :comment="$comment" wire:key="comment-{{$comment->id}}" />
        @empty
            <div class="text-center text-gray-900 dark:text-gray-200">
                <span> No Comments Posted</span>
            </div>
        @endforelse
    </div>
    <div class="my-2">
        {{ $this->comments->links() }}
    </div>
</div>
