<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Rina (Reporter)',
            'email' => 'reporter@mbg.test',
            'role' => 'reporter',
        ]);

        User::factory()->create([
            'name' => 'Dedi (Monitor)',
            'email' => 'monitor@mbg.test',
            'role' => 'monitor',
        ]);

        User::factory()->create([
            'name' => 'Sari (Koordinator)',
            'email' => 'koordinator@mbg.test',
            'role' => 'koordinator',
        ]);
    }
}
