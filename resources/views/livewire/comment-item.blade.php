<div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
    <div class="flex items-center mb-4 text-sm user-meta">
        <x-posts.author :author="$comment->user" size="sm" />
        <span class="text-gray-900 dark:text-gray-200">. {{ $comment->created_at_diff }}</span>
    </div>
    <div class="text-sm text-justify text-gray-900 dark:text-gray-200">
        {{ $comment->body }}
    </div>
</div>
