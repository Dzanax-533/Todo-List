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
        $faker = \Faker\Factory::create();

        // ensure a set of common tags exist
        $tagNames = ['Belajar', 'Proyek', 'Penting', 'Pekerjaan', 'Pribadi', 'Urgent', 'Low Priority', 'Bug', 'Enhancement'];
        $tags = [];
        foreach ($tagNames as $name) {
            $t = Tag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name, 'slug' => \Illuminate\Support\Str::slug($name)]
            );
            $tags[] = $t;
        }

        // add a few fixed sample tasks
        $t1 = Task::create([
            'title' => 'Belajar Laravel',
            'description' => 'Mempelajari dasar-dasar Laravel',
            'is_completed' => false,
        ]);
        $t1->tags()->sync([$tags[0]->id]); // Belajar

        $t2 = Task::create([
            'title' => 'Mengerjakan Proyek To-Do List',
            'description' => 'Membuat aplikasi To-Do List menggunakan Laravel',
            'is_completed' => false,
        ]);
        $t2->tags()->sync([$tags[1]->id, $tags[2]->id]); // Proyek, Penting

        // add some specific tasks to demonstrate due_date and recurrence
        $tOverdue = Task::create([
            'title' => 'Submit laporan',
            'description' => 'Laporan bulanan',
            'is_completed' => false,
            'due_date' => \Carbon\Carbon::today()->subDays(3)->toDateString(),
            'is_recurring' => false,
            'recurrence' => null,
        ]);
        $tOverdue->tags()->sync([$tags[3]->id]);

        $tToday = Task::create([
            'title' => 'Rapat tim',
            'description' => 'Rapat koordinasi proyek',
            'is_completed' => false,
            'due_date' => \Carbon\Carbon::today()->toDateString(),
            'is_recurring' => false,
            'recurrence' => null,
        ]);
        $tToday->tags()->sync([$tags[1]->id]);

        $tDaily = Task::create([
            'title' => 'Cek email pagi',
            'description' => 'Periksa dan balas email penting',
            'is_completed' => false,
            'due_date' => \Carbon\Carbon::today()->toDateString(),
            'is_recurring' => true,
            'recurrence' => 'daily',
        ]);
        $tDaily->tags()->sync([$tags[4]->id]);

        $tWeekly = Task::create([
            'title' => 'Jadwal meeting mingguan',
            'description' => 'Standup dan review minggu',
            'is_completed' => false,
            'due_date' => \Carbon\Carbon::today()->addDays(3)->toDateString(),
            'is_recurring' => true,
            'recurrence' => 'weekly',
        ]);
        $tWeekly->tags()->sync([$tags[1]->id]);

        $tMonthly = Task::create([
            'title' => 'Backup data',
            'description' => 'Backup database dan file proyek',
            'is_completed' => false,
            'due_date' => \Carbon\Carbon::today()->addDays(7)->toDateString(),
            'is_recurring' => true,
            'recurrence' => 'monthly',
        ]);
        $tMonthly->tags()->sync([$tags[5]->id]);

        // generate many random tasks with varied due dates and occasional recurring flag
        for ($i = 0; $i < 25; $i++) {
            $hasDue = $faker->boolean(70); // 70% have due_date
            $isRecurring = $faker->boolean(15); // 15% recurring
            $dueDate = $hasDue ? \Carbon\Carbon::today()->addDays($faker->numberBetween(-7, 30))->toDateString() : null;
            $recurrence = null;
            if ($isRecurring) {
                $recurrence = $faker->randomElement(['daily', 'weekly', 'monthly']);
            }

            $task = Task::create([
                'title' => ucfirst($faker->words($faker->numberBetween(2,5), true)),
                'description' => $faker->paragraph(),
                'is_completed' => (bool) $faker->numberBetween(0,1),
                'due_date' => $dueDate,
                'is_recurring' => $isRecurring,
                'recurrence' => $recurrence,
            ]);

            // attach 0-3 random tags
            $take = $faker->numberBetween(0, 3);
            if ($take > 0) {
                $selected = $faker->randomElements($tags, $take);
                $task->tags()->sync(array_map(fn($t) => $t->id, $selected));
            }
        }
    }
}
