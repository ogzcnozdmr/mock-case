<?php

namespace App\Console\Commands;

use App\Classes\TaskDistribute;
use App\Models\TaskAssigned;
use App\Models\TaskGroup;
use Illuminate\Console\Command;

class TaskDistributeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:distribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Task atamalarını yapar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $taskGroups = TaskGroup::where(['assigned' => '0'])->get();
        foreach ($taskGroups as $taskGroup) {
            //task atamalarını yapar
            $taskDistributeClass = new TaskDistribute($taskGroup['id']);
            $taskDistributes = $taskDistributeClass->setTasks();
            $week = 0;
            foreach ($taskDistributes as $taskDistribute) {
                //task atamalarını veri tabanına kaydeder
                TaskAssigned::create([
                    'task_groups_id' => $taskGroup['id'],
                    'tasks_id' => $taskDistribute['taskId'],
                    'developers_id' => $taskDistribute['developerId'],
                    'duration' => $taskDistribute['duration'],
                    'week' => $taskDistribute['week']
                ]);
                //maximum haftayı bulur
                if ($taskDistribute['week'] > $week) {
                    $week = $taskDistribute['week'];
                }
            }
            //task grubu bitirirken maximum haftayla beraber atamayı kaydeder
            TaskGroup::where(['id' => $taskGroup['id']])->update(['assigned' => '1', 'week' => $week]);
        }
    }
}
