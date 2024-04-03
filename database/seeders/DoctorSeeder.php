<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::create(
            [
                "name" => "Benjamin",
                "last_name" => "Quiroz",
                "specialty_id" => 1
            ]
        );

        Doctor::create(
            [
                "name" => "Sebastian",
                "last_name" => "Gonzales",
                "specialty_id" => 2
            ]
        );

    }
}
