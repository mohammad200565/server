<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->verification_state == "verified";
    }
    public function view(User $user): bool
    {
        return $user->verification_state == "verified";
    }
    public function create(User $user): bool
    {
        return $user->verification_state == "verified";
    }
    public function update(User $user, Comment $comment): bool
    {
        return $user->verification_state == "verified" && $user->id == $comment->user_id;
    }
    public function delete(User $user, Comment $comment): bool
    {
        return  $user->verification_state == "verified" && $user->id == $comment->user_id;
    }
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
