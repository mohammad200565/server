<?php

namespace App\Policies;

use App\Models\Rent;
use App\Models\User;

class RentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Rent $rent): bool
    {
        return $user->id === $rent->user_id;
    }
    public function create(User $user): bool
    {
        return true;
    }
    public function update(User $user, Rent $rent): bool
    {
        return $user->id === $rent->user_id;
    }
    public function delete(User $user, Rent $rent): bool
    {
        return $user->id === $rent->user_id;
    }
    public function restore(User $user, Rent $rent): bool
    {
        return false;
    }
    public function forceDelete(User $user, Rent $rent): bool
    {
        return false;
    }
}
