<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\Tag;
use App\Models\User;

class TaggingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task_with_tags_and_filter_by_tag()
    {
        // authenticate a user (routes require auth)
        $user = User::factory()->create();
        $this->actingAs($user);

        // seed two tasks
        $t1 = Task::create(['title' => 'Task One', 'description' => 'A', 'is_completed' => false]);
        $t2 = Task::create(['title' => 'Task Two', 'description' => 'B', 'is_completed' => false]);

        $tag = Tag::create(['name' => 'Work', 'slug' => 'work']);
        $t1->tags()->sync([$tag->id]);

        // Filter by tag
        $response = $this->get('/tasks?tag=work');
        $response->assertStatus(200);
        $response->assertSee('Task One');
        $response->assertDontSee('Task Two');
    }
}
