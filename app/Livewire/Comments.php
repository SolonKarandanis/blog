<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public Post $post;

    public function mount(Post $post){
        $this->post = $post;
    }

    #[On('commentCreated')]
    #[On('commentDeleted')]
    #[On('commentUpdated')]
    public function refreshComments(): void
    {
        $this->resetPage();
    }

    public function comments()
    {
        // 1. Get the paginated parent comments with their children
        $comments = Comment::query()
            ->where('post_id', $this->post->id)
            ->whereNull('parent_id')
            ->with('childComments') // Load children, but not their users yet
            ->withCount('childComments')
            ->orderByDesc('created_at')
            ->paginate(5);

        // 2. Collect all user IDs from parents and children
        $userIds = $comments->pluck('user_id');

        $childUserIds = $comments->flatMap(function ($comment) {
            return $comment->childComments->pluck('user_id');
        });

        $allUserIds = $userIds->merge($childUserIds)->unique()->filter();

        // 3. Eager load all users in a single query
        if ($allUserIds->isNotEmpty()) {
//            keyBy('id')
//            [
//                5  => User(id: 5, name: 'Alice'),
//               12 => User(id: 12, name: 'Bob'),
//               23 => User(id: 23, name: 'Charlie')
//            ]
            $users = User::whereIn('id', $allUserIds)->get()->keyBy('id');
        } else {
            $users = collect();
        }

        // 4. Manually associate the users back to the comments
        $comments->each(function ($comment) use ($users) {
            if ($users->has($comment->user_id)) {
                // This sets the 'user' relation on the parent comment model
                $comment->setRelation('user', $users->get($comment->user_id));
            }
            $comment->childComments->each(function ($childComment) use ($users) {
                if ($users->has($childComment->user_id)) {
                    // This sets the 'user' relation on the child comment model
                    $childComment->setRelation('user', $users->get($childComment->user_id));
                }
            });
        });

        return $comments;
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->comments()
        ]);
    }
}
