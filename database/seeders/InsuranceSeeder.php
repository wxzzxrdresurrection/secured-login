<?php

namespace Database\Seeders;

use App\Models\Insurance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Insurance::create([
            'name' => 'New York Life',
        ]);

        Insurance::create([
            'name' => 'Metlife',
        ]);

        Insurance::create([
            'name' => 'MAPFRE',
        ]);

        Insurance::create([
            'name' => 'Allianz Seguros',
        ]);

        Insurance::create([
            'name' => 'AXA Seguros',
        ]);

        Insurance::create([
            'name' => 'Seguros Inbursa',
        ]);

        Insurance::create([
            'name' => 'Seguros Atlas',
        ]);

        Insurance::create([
            'name' => 'GNP Seguros',
        ]);

        Insurance::create([
            'name' => 'Zurich Santander',
        ]);
    }
}
