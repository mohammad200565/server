<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    public function run(): void
    {
        User::create([
            'first_name' => 'Daleel',
            'last_name' => 'Admin',
            'profileImage' => 'https://www.pngall.com/wp-content/uploads/5/Admin-Profile-PNG-Image.png',
            'personIdImage' => 'https://www.pngall.com/wp-content/uploads/5/Admin-Profile-PNG-Image.png',
            'birthdate' => '1990-01-01',
            'verification_state' => 'verified',
            'phone' => '0096395718434',
            'email' => 'daleel@admin.com',
            'password' => Hash::make('Daleel2025@DaleelAdmin'),
        ]);
        User::factory(100)->create();
        $this->call(DepartmentSeeder::class);
        for ($i = 0; $i < 500; $i++) {
            User::inRandomOrder()->first()?->favorites()->toggle(Department::inRandomOrder()->first()?->id);
        }
        $this->call(ReviewSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(RentSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
