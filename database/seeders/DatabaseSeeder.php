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
        if (! app()->environment('production')) {
            User::factory()->customer()->count(10)->create();
            User::factory()->admin()->count(10)->create();
            $this->call([
                CategorySeeder::class,
                ProductSeeder::class,
                AdminUserSeeder::class
            ]);
        }
    }
}
