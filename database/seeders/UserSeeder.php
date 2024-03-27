<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Luis Zapata',
            'email' => 'luiszapata0815@gmail.com',
            'phone' => '8713530073',
            'password' => Hash::make('Luis200315'),
            'active' => '1',
            'role_id' => 1,
            'extra_code' => Hash::make('123456'),
        ]);
    }
}
