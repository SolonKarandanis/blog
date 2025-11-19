<div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5" wire:key="comment-{{$comment->id}}">
    <div class="flex items-center mb-4 text-sm user-meta">
        <x-posts.author :author="$comment->user" size="sm" />
        <span class="text-gray-900 dark:text-gray-200">. {{ $comment->created_at_diff }}</span>
    </div>
    @if($editing)
        <form wire:submit.prevent="updateComment">
            <textarea
                wire:model="editedBody"
                class="w-full rounded-lg p-4 bg-gray-50 dark:bg-gray-600 focus:outline-none text-sm text-gray-900 dark:text-gray-200 border-gray-200 placeholder:text-gray-400"
                rows="4"></textarea>
            <div class="mt-2">
                <button type="submit" class="text-sm font-semibold text-blue-600">Save</button>
                <button wire:click.prevent="cancelEditing" class="text-sm font-semibold text-gray-600 ml-2">Cancel</button>
            </div>
        </form>
    @else
        <div class="text-sm text-justify text-gray-900 dark:text-gray-200">
            {{ $comment->body }}
        </div>
    @endif
    <div class="mt-2">
        <a wire:click.prevent="startReply" href="#" class="text-sm text-indigo-600 mr-3">Reply</a>
        @if (\Illuminate\Support\Facades\Auth::id() == $comment->user_id)
            <a wire:click.prevent="startCommentEdit" href="#" class="text-sm text-blue-600 mr-3">Edit</a>
            <a wire:click.prevent="deleteComment" href="#" class="text-sm text-red-600">Delete</a>
        @endif
    </div>
    @if ($replying)
        <livewire:comment-create :post="$comment->post" :parent-comment="$comment"/>
    @endif
    @if ($comment->childComments->count())
        <div class="mt-4 ml-4">
            @foreach($comment->childComments as $childComment)
                <livewire:comment-item :comment="$childComment" wire:key="comment-{{$childComment->id}}"/>
            @endforeach
        </div>
    @endif
</div>
