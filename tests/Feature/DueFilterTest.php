<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class DueFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_due_filters_work_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $yesterday = now()->subDay()->toDateString();
        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        Task::create(['title' => 'Overdue Task', 'description' => 'Old', 'is_completed' => false, 'due_date' => $yesterday]);
        Task::create(['title' => 'Today Task', 'description' => 'Now', 'is_completed' => false, 'due_date' => $today]);
        Task::create(['title' => 'Upcoming Task', 'description' => 'Soon', 'is_completed' => false, 'due_date' => $tomorrow]);

        // Overdue
        $resOver = $this->get('/tasks?due=overdue');
        $resOver->assertStatus(200);
        $resOver->assertSee('Overdue Task');
        $resOver->assertDontSee('Today Task');
        $resOver->assertDontSee('Upcoming Task');

        // Today
        $resToday = $this->get('/tasks?due=today');
        $resToday->assertStatus(200);
        $resToday->assertSee('Today Task');
        $resToday->assertDontSee('Overdue Task');
        $resToday->assertDontSee('Upcoming Task');

        // Upcoming
        $resUp = $this->get('/tasks?due=upcoming');
        $resUp->assertStatus(200);
        $resUp->assertSee('Upcoming Task');
        $resUp->assertDontSee('Overdue Task');
        $resUp->assertDontSee('Today Task');
    }
}
