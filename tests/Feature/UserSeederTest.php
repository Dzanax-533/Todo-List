<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_muis_user()
    {
        // Run DatabaseSeeder
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'pccmuis77@gmail.com',
            'name' => 'Muis Nuryana',
        ]);
    }
}
