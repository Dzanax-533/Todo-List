<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create a demo user for quick login
        \App\Models\User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
        ]);

        // call task seeder to populate tasks + tags
        $this->call(TaskSeeder::class);
    }
}
