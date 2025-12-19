<?php

namespace App\Policies;

use App\Models\Rent;
use App\Models\User;

class RentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->verification_state == "verified";
    }
    public function view(User $user, Rent $rent): bool
    {
        return $user->verification_state == "verified" && $user->id === $rent->user_id;
    }
    public function create(User $user): bool
    {
        return $user->verification_state == "verified";
    }
    public function update(User $user, Rent $rent): bool
    {
        return $user->verification_state == "verified" && $user->id === $rent->user_id;
    }
    public function delete(User $user, Rent $rent): bool
    {
        return $user->verification_state == "verified" && $user->id === $rent->user_id;
    }
    public function cancelRent(User $user, Rent $rent): bool
    {
        $department = $rent->department;
        return $user->verification_state == "verified" && ($user->id === $department->user_id || $user->id === $rent->user_id);
    }
    public function approveRent(User $user, Rent $rent): bool
    {
        $department = $rent->department;
        return $user->verification_state == "verified" && $user->id === $department->user_id;
    }
    public function rejectRent(User $user, Rent $rent): bool
    {
        $department = $rent->department;
        return $user->verification_state == "verified" && $user->id === $department->user_id;
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
