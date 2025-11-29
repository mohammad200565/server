<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Department $department): bool
    {
        return true;
    }
    public function create(User $user): bool
    {
        return $user->verification_state == "verified";
    }
    public function update(User $user, Department $department): bool
    {
        return $user->verification_state == "verified" && $user->id === $department->user_id;
    }
    public function delete(User $user, Department $department): bool
    {
        return $user->verification_state == "verified" && $user->id === $department->user_id;
    }
    public function restore(User $user, Department $department): bool
    {
        return false;
    }
    public function forceDelete(User $user, Department $department): bool
    {
        return false;
    }
}
