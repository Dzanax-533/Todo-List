<?php

namespace Database\Seeders;
use App\Models\Task;
use App\Models\Tag;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $t1 = Task::create([
            'title' => 'Belajar Laravel',
            'description' => 'Mempelajari dasar-dasar Laravel',
            'is_completed' => false,
        ]);

        $t2 = Task::create([
            'title' => 'Mengerjakan Proyek To-Do List',
            'description' => 'Membuat aplikasi To-Do List menggunakan Laravel',
            'is_completed' => false,
        ]);

        // Create some tags and attach
        $tagLearn = Tag::firstOrCreate(['slug' => \Illuminate\Support\Str::slug('belajar')], ['name' => 'Belajar', 'slug' => \Illuminate\Support\Str::slug('belajar')]);
        $tagProject = Tag::firstOrCreate(['slug' => \Illuminate\Support\Str::slug('proyek')], ['name' => 'Proyek', 'slug' => \Illuminate\Support\Str::slug('proyek')]);
        $tagImportant = Tag::firstOrCreate(['slug' => \Illuminate\Support\Str::slug('penting')], ['name' => 'Penting', 'slug' => \Illuminate\Support\Str::slug('penting')]);

        $t1->tags()->sync([$tagLearn->id]);
        $t2->tags()->sync([$tagProject->id, $tagImportant->id]);
    }
}
