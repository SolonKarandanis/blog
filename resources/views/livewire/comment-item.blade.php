@php use Illuminate\Support\Facades\Auth; @endphp
<div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
    <div class="flex items-center mb-4 text-sm user-meta">
        <x-posts.author :author="$comment->user" size="sm" />
        <span class="text-gray-900 dark:text-gray-200">. {{ $comment->created_at_diff }}</span>
    </div>
    @if($editing)
        <livewire:comment-create :comment-model="$comment"/>
    @else
        <div class="text-sm text-justify text-gray-900 dark:text-gray-200">
            {{ $comment->body }}
        </div>
    @endif
    <div>
        <a wire:click.prevent="startReply" href="#" class="text-sm text-indigo-600 mr-3">Reply</a>
        @if (Auth::id() == $comment->user_id)
            <a wire:click.prevent="startCommentEdit" href="#" class="text-sm text-blue-600 mr-3">Edit</a>
            <a wire:click.prevent="deleteComment" href="#" class="text-sm text-red-600">Delete</a>
        @endif
    </div>
</div>
