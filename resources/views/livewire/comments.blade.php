<div class="mt-10 comments-box border-t border-gray-100 pt-10">
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-200 mb-5">Discussions</h2>
    <livewire:comment-create :post="$post" />

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
