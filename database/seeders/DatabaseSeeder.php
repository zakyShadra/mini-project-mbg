<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Rina',
            'username' => 'rina',
            'password' => Hash::make('rina123'),
            'role' => 'reporter',
        ]);

        User::factory()->create([
            'name' => 'Dedi',
            'username' => 'dedi',
            'password' => Hash::make('dedi123'),
            'role' => 'monitor',
        ]);

        User::factory()->create([
            'name' => 'Sari',
            'username' => 'sari',
            'password' => Hash::make('sari123'),
            'role' => 'koordinator',
        ]);
    }
}
