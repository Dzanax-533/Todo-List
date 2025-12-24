<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class DueDateRecurringTest extends TestCase
{
    use RefreshDatabase;

    public function test_due_date_and_recurring_saved_and_displayed()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/tasks', [
            'title' => 'Task with due',
            'description' => 'Has due date',
            'due_date' => '2025-12-31',
            'is_recurring' => true,
            'recurrence' => 'weekly',
        ]);

        $response->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Task with due',
            'due_date' => '2025-12-31',
            'is_recurring' => 1,
            'recurrence' => 'weekly',
        ]);

        $task = Task::where('title', 'Task with due')->first();

        $show = $this->get('/tasks/' . $task->id);
        $show->assertSee('2025-12-31');
        $show->assertSee('Weekly');
    }
}
