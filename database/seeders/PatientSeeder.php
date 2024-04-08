<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create(
            [
                "name" => "Josue",
                "last_name" => "Soto",
                "gender" => "M",
                "insurance_id" => 1
            ],
        );

        Patient::create(
            [
                "name" => "Carlos",
                "last_name" => "Reyes",
                "gender" => "M",
                "insurance_id" => 3
            ]
        );
    }
}
