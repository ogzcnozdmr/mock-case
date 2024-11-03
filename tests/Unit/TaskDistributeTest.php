<?php

namespace Tests\Unit;

use App\Classes\TaskDistribute;
use App\Classes\TaskDistribute\Developer;
use App\Classes\TaskDistribute\Task;
use PHPUnit\Framework\TestCase;

class TaskDistributeTest extends TestCase
{
    /**
     * Distribute Assign Task Test
     */
    public function test_distribute_assign_task(): void
    {
        $developer = new Developer(1, 3);
        $task = new Task(1, 6, 3);
        $taskDistribute = new TaskDistribute(0);
        $assigns = $taskDistribute->assignTasks([$developer], [$task]);
        //diziden sadece 1 değer dönmesi
        $this->assertCount(1, $assigns, 'Assert dizisi hatalı');
        $assign = current($assigns);
        //sonuçların kesin doğru gelmesi
        $this->assertEquals($assign['developerId'], $developer->id, 'Developer Id hatalı');
        $this->assertEquals($assign['taskId'], 1, 'Task Id Hatalı');
        $this->assertEquals($assign['duration'], 6, 'Duration Hatalı');
        $this->assertEquals($assign['week'], 1, 'Week Hatalı');
    }
}
