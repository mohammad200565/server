<?php

namespace App\Policies;

use App\Models\EditedRent;
use App\Models\User;

class EditedRentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->verification_state == "verified";
    }
    public function view(User $user, EditedRent $edited_rent): bool
    {
        return $user->verification_state === 'verified'
            && (
                $user->id === $edited_rent->user_id ||
                $user->id === $edited_rent->department->user_id
            );
    }
    public function approveRent(User $user, EditedRent $edited_rent): bool
    {
        return $user->verification_state == "verified" && $user->id == $edited_rent->department->user->id;
    }
    public function rejectRent(User $user, EditedRent $edited_rent): bool
    {
        return $user->verification_state == "verified" && $user->id == $edited_rent->department->user->id;
    }
    public function restore(User $user, EditedRent $edited_rent): bool
    {
        return false;
    }
    public function forceDelete(User $user, EditedRent $edited_rent): bool
    {
        return false;
    }
}
