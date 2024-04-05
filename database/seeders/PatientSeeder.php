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
                "birth_date" => "2006-11-15",
                "gender" => "M",
                "insurance_id" => 1
            ],
        );

        Patient::create(
            [
                "name" => "Carlos",
                "last_name" => "Reyes",
                "birth_date" => "2003-02-14",
                "gender" => "M",
                "insurance_id" => 3
            ]
        );
    }
}
