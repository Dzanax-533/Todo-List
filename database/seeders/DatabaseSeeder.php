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
        // create or update user for the project owner
        \App\Models\User::updateOrCreate(
            ['email' => 'pccmuis77@gmail.com'],
            [
                'name' => 'Muis Nuryana',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // call task seeder to populate tasks + tags
        $this->call(TaskSeeder::class);
    }
}
