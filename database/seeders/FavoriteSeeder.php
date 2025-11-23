<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $departments = Department::all();
        foreach ($users as $user) {
            $randomDepartments = $departments->random(rand(1, 5));
            foreach ($randomDepartments as $department) {
                Favorite::firstOrCreate([
                    'user_id'       => $user->id,
                    'department_id' => $department->id,
                ]);
            }
        }
    }
}
