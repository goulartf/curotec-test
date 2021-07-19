<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * @test
     */
    public function it_lists_resources()
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->get('/api/tasks');

        $response
            ->assertJson([
                'data' => [
                    ['id' => $tasks[0]->id],
                    ['id' => $tasks[1]->id],
                    ['id' => $tasks[2]->id]
                ]
            ])
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function it_creates_resources()
    {
        $task = ['title' => 'asd'];

        $response = $this->post('/api/tasks', ['title' => $task['title']]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id' => $task['title']
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_updates_resources()
    {
        $task = Task::factory()->create();

        $response = $this->put('api/tasks/'.$task->id, ['title' => 'asd']);

        $response
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'title' => 'asd'
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_deletes_resources()
    {
        $task = Task::factory()->create();

        $response = $this->delete('api/tasks/'.$task->id);

        $response
            ->assertSuccessful();
    }
}
