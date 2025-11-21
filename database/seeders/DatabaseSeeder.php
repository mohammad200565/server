<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    public function run(): void
    {
        User::factory(100)->create();
        $this->call(DepartmentSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(RentSeeder::class);
    }
}
