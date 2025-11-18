<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CommentItem extends Component
{
    public Comment $comment;
    public bool $editing = false;
    public bool $replying = false;

    #[Rule('required|min:3|max:200')]
    public string $editedBody;

    protected $listeners = [
        'cancelEditing' => 'cancelEditing',
        'commentUpdated' => 'commentUpdated',
        'commentCreated' => 'commentCreated',
    ];

    public function mount(Comment $comment): void
    {
        $this->comment = $comment;
    }

    public function deleteComment(): void
    {
        $user= auth()->user();
        if(!$user){
            $this->redirect('/login');
        }
        if ($this->comment->user_id != $user->id) {
            response('You are not allowed to perform this action', 403);
        }

        $this->comment->delete();
        $this->dispatch('commentDeleted');
    }

    public function startCommentEdit(): void
    {
        $this->editedBody = $this->comment->body;
        $this->editing = true;
    }

    public function updateComment()
    {
        $this->validateOnly('editedBody');

        $this->comment->body = $this->editedBody;
        $this->comment->save();

        $this->editing = false;
        $this->dispatch('commentUpdated');
    }

    public function cancelEditing(): void
    {
        $this->editing = false;
        $this->replying = false;
    }

    public function commentUpdated(): void
    {
        $this->editing = false;
    }

    public function startReply(): void
    {
        $this->replying = true;
    }

    public function commentCreated(): void
    {
        $this->replying = false;
    }

    public function render()
    {
        return view('livewire.comment-item');
    }
}
