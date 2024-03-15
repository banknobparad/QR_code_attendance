<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    // php artisan db:seed --class=StudentSeeder
    public function run(): void
    {
        User::factory()->count(13)->create();
    }
}
