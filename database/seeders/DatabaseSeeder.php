<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Year;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        {
            DB::table('users')->insert([
                'name' => 'Administrator',
                'email' => 'administrator@gmail.com',
                'password' => Hash::make('administrator'),
                'role' => 'Administrator',
                'email_verified_at' => date(now()),
                'created_at' => date(now()),
                'updated_at' => date(now()),
            ]);
            DB::table('users')->insert([
                'name' => 'Teacher',
                'email' => 'teacher@gmail.com',
                'password' => Hash::make('teacher'),
                'role' => 'Teacher',
                'email_verified_at' => date(now()),
                'created_at' => date(now()),
                'updated_at' => date(now()),
            ]);

            //create branch (สาขา)
            Branch::insert([
                ['name' => 'สาขาวิทยาการคอมพิวเตอร์', 'branch' => '1'],
                ['name' => 'สาขาเทคโนโลยีสารสนเทศ', 'branch' => '2'],
                ['name' => 'สาขาเทคโนโลยีเครือข่ายคอมพิวเตอร์', 'branch' => '3'],
                ['name' => 'สาขาภูมิสารสนเทศ', 'branch' => '4'],
            ]);


            //create years (ปี)
            Year::insert([
                ['name' => 'นักศึกษาชั้นปีที่ 1', 'year' => '1'],
                ['name' => 'นักศึกษาชั้นปีที่ 2', 'year' => '2'],
                ['name' => 'นักศึกษาชั้นปีที่ 3', 'year' => '3'],
                ['name' => 'นักศึกษาชั้นปีที่ 4', 'year' => '4'],
            ]);
        }

    }
}
