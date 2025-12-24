<?php

namespace Database\Seeders;
use App\Models\Task;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Task::create([
            'title' => 'Belajar Laravel',
            'description' => 'Mempelajari dasar-dasar Laravel',
            'is_completed' => false,
        ]);

        Task::create([
            'title' => 'Mengerjakan Proyek To-Do List',
            'description' => 'Membuat aplikasi To-Do List menggunakan Laravel',
            'is_completed' => false,
        ]);
    }
}
