<?php

namespace Tests\Unit;

use App\Services\TaskServices;
use PHPUnit\Framework\TestCase;

class TaskFetchTest extends TestCase
{
    /**
     * Task Fetch Test
     */
    public function test_task_services_fetch(): void
    {
        $taskServices = app(TaskServices::class);
        $tasks = $taskServices->getData([
            [
                'id' => 2,
                'zorluk' => 2,
                'sure' => 3
            ]
        ]);
        //diziden 1 değer dönmesi
        $this->assertCount(1, $tasks, 'Task servisi dizisi hatalı');
        $task = current($tasks);
        //sonuçların kesin doğru gelmesi
        $this->assertEquals($task['id'], 2, 'Task Id hatalı');
        $this->assertEquals($task['difficulty'], 2, 'Task Difficulty hatalı');
        $this->assertEquals($task['duration'], 3, 'Task Duration hatalı');
    }
}
