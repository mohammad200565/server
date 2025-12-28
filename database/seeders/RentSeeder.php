<?php

namespace Database\Seeders;

use App\Models\Rent;
use Illuminate\Database\Seeder;

class RentSeeder extends Seeder
{

    public function run(): void
    {
        Rent::factory()->count(250)->create();
    }
}
