<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CommentCreate extends Component
{
    public Post $post;
    public ?Comment $commentModel = null;
    public ?Comment $parentComment = null;

    #[Rule('required|min:3|max:200')]
    public string $body = '';

    public function mount(Post $post, $commentModel = null, $parentComment = null): void
    {
        $this->post = $post;
        $this->commentModel = $commentModel;
        $this->body = $commentModel?->body ?? '';

        $this->parentComment = $parentComment;

    }

    public function createComment(): void
    {
        $user = auth()->user();
        if (!$user) {
            $this->redirect('/login');
        }

        $this->validateOnly('body');

        if ($this->commentModel) {
            if ($this->commentModel->user_id != $user->id) {
                response('You are not allowed to perform this action', 403);
            }

            $this->commentModel->body = $this->body;

            $this->commentModel->save();

            $this->body = '';
            $this->dispatch('commentUpdated');
        } else {
            $comment = Comment::create([
                'body' => $this->body,
                'post_id' => $this->post->id,
                'user_id' => $user->id,
                'parent_id' => $this->parentComment?->id
            ]);

            $this->dispatch('commentCreated', $comment->id);
            $this->body = '';
        }
        $this->reset('body');
    }

    public function render()
    {
        return view('livewire.comment-create');
    }
}
