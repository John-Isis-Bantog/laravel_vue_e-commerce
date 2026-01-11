<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(10)->create([
            'role' => 'customer'
        ]);

        User::factory()->count(10)->create([
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => '123',
            'email' => '123@example.com',
            'role' => 'admin',
        ]);
    }
}
