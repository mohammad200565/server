<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
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
    public function update(User $user, Review $review): bool
    {
        return $user->verification_state == "verified" && $user->id === $review->user_id;
    }
    public function delete(User $user, Review $review): bool
    {
        return $user->verification_state == "verified" && $user->id === $review->user_id;
    }
    public function restore(User $user, Review $review): bool
    {
        return false;
    }
    public function forceDelete(User $user, Review $review): bool
    {
        return false;
    }
}
