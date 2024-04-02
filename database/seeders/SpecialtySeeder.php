<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialty::create([
            'name' => 'Alergología',
        ]);

        Specialty::create([
            'name' => 'Anestesiología',
        ]);

        Specialty::create([
            'name' => 'Angiología',
        ]);

        Specialty::create([
            'name' => 'Cardiología',
        ]);

        Specialty::create([
            'name' => 'Cirugía pediátrica',
        ]);

        Specialty::create([
            'name' => 'Cirugía general',
        ]);

        Specialty::create([
            'name' => 'Cirugía plástica',
        ]);

        Specialty::create([
            'name' => 'Dermatología',
        ]);

        Specialty::create([
            'name' => 'Endocrinología',
        ]);

        Specialty::create([
            'name' => 'Gastroenterología',
        ]);

        Specialty::create([
            'name' => 'Geriatría',
        ]);

        Specialty::create([
            'name' => 'Ginecología',
        ]);

        Specialty::create([
            'name' => 'Hematología',
        ]);

        Specialty::create([
            'name' => 'Hepatología',
        ]);

        Specialty::create([
            'name' => 'Infectología',
        ]);

        Specialty::create([
            'name' => 'Medicina interna',
        ]);

        Specialty::create([
            'name' => 'Nefrología',
        ]);

        Specialty::create([
            'name' => 'Neumología',
        ]);

        Specialty::create([
            'name' => 'Neurología',
        ]);

        Specialty::create([
            'name' => 'Nutriología',
        ]);

        Specialty::create([
            'name' => 'Oftalmología',
        ]);

        Specialty::create([
            'name' => 'Oncología',
        ]);

        Specialty::create([
            'name' => 'Ortopedia',
        ]);

        Specialty::create([
            'name' => 'Otorrinolaringología',
        ]);

        Specialty::create([
            'name' => 'Pediatría',
        ]);

        Specialty::create([
            'name' => 'Psiquiatría',
        ]);

        Specialty::create([
            'name' => 'Radiología',
        ]);

        Specialty::create([
            'name' => 'Reumatología',
        ]);

        Specialty::create([
            'name' => 'Traumatología',
        ]);

        Specialty::create([
            'name' => 'Urología',
        ]);
    }
}
