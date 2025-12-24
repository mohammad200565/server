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
            'birthdate' => '1990-01-01',
            'verification_state' => 'verified',
            'phone' => '0933995477',
            'email' => 'daleel@admin.com',
            'password' => Hash::make('Daleel2025@DaleelAdmin'),
        ]);
        User::create([
            'first_name' => 'Mohammad',
            'last_name' => 'Al Homsi',
            'profileImage' => 'users/profile/mohammadAlHomsi.jpg',
            'birthdate' => '2005-06-05',
            'verification_state' => 'verified',
            'phone' => '0935038135',
            'email' => 'mmmmohammadalhomsi@admin.com',
            'password' => Hash::make('password'),
            'location' => [
                'city' => 'Damascus',
            ]
        ]);
        User::create([
            'first_name' => 'Mohammad',
            'last_name' => 'Haboosh',
            'profileImage' => 'users/profile/mohammadHaboosh.jpg',
            'birthdate' => '2004-07-08',
            'verification_state' => 'verified',
            'phone' => '0943885435',
            'email' => 'mohammadhaboosh@admin.com',
            'password' => Hash::make('password'),
            'location' => [
                'city' => 'Damascus',
            ]
        ]);
        User::create([
            'first_name' => 'Yazan',
            'last_name' => 'Mahfooz',
            'profileImage' => 'users/profile/yazanMahfooz.jpg',
            'birthdate' => '2005-12-26',
            'verification_state' => 'verified',
            'phone' => '0933803688',
            'email' => 'yazanmahfooz8@admin.com',
            'password' => Hash::make('password'),
            'location' => [
                'city' => 'Damascus'
            ]
        ]);
        User::create([
            'first_name' => 'Loulia',
            'last_name' => 'Al Shaar',
            'profileImage' => 'users/profile/louliaAlShaar.jpg',
            'birthdate' => '2005-1-1',
            'verification_state' => 'verified',
            'phone' => '0991744605',
            'email' => 'louliaalshaar@admin.com',
            'password' => Hash::make('password'),
            'location' => [
                'city' => 'Damascus'
            ]
        ]);
        User::create([
            'first_name' => 'Zain',
            'last_name' => 'Nhlawy',
            'profileImage' => 'users/profile/zainNhlawy.jpg',
            'birthdate' => '2005-1-1',
            'verification_state' => 'verified',
            'phone' => '0954179314',
            'email' => 'zainnhlawy@admin.com',
            'password' => Hash::make('password'),
            'location' => [
                'city' => 'Damascus'
            ]
        ]);

        $departments = [
            [
                'headDescription' => 'Homsi Home',
                'user_id' => 2,
                'area' => 50,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'rentFee' => 500,
                'status' => 'furnished',
                'verification_state' => 'verified',
                'floor' => 1,
                'location' => ['city' => 'Damascus'],
                'image' => 'departments/Test.jpg',
            ],
            [
                'headDescription' => 'Habbosh Home',
                'user_id' => 3,
                'area' => 50,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'rentFee' => 500,
                'status' => 'furnished',
                'verification_state' => 'verified',
                'floor' => 1,
                'location' => ['city' => 'Damascus'],
                'image' => 'departments/Test.jpg',
            ],
            [
                'headDescription' => 'Yazan Home',
                'user_id' => 4,
                'area' => 50,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'rentFee' => 500,
                'status' => 'furnished',
                'verification_state' => 'verified',
                'floor' => 1,
                'location' => ['city' => 'Damascus'],
                'image' => 'departments/Test.jpg',
            ],
            [
                'headDescription' => 'Loulia Home',
                'user_id' => 5,
                'area' => 50,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'rentFee' => 500,
                'status' => 'furnished',
                'verification_state' => 'verified',
                'floor' => 1,
                'location' => ['city' => 'Damascus'],
                'image' => 'departments/Test.jpg',
            ],
            [
                'headDescription' => 'Zain Home',
                'user_id' => 6,
                'area' => 50,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'rentFee' => 500,
                'status' => 'furnished',
                'verification_state' => 'verified',
                'floor' => 1,
                'location' => ['city' => 'Damascus'],
                'image' => 'departments/Test.jpg',
            ],
        ];

        foreach ($departments as $deptData) {
            $image = $deptData['image'];
            unset($deptData['image']);
            $department = Department::create($deptData);
            $department->images()->create([
                'path' => $image,
            ]);
        }

        for ($i = 0; $i < 500; $i++) {
            User::inRandomOrder()->first()?->favorites()->toggle(Department::inRandomOrder()->first()?->id);
        }
        $this->call(ReviewSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(RentSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
