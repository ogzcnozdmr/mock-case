<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\TaskAssigned;
use App\Models\TaskGroup;

class TaskController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function list()
    {
        $tasks = TaskGroup::where(['assigned' => '1'])->get();
        return view('task.list', ['tasks' => $tasks]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws \Exception
     */
    public function detail(int $id)
    {
        $developers = Developer::all();
        $taskGroup = TaskGroup::where([
            'id' => $id
        ])->first();
        //task grubu yoksa
        if (empty($taskGroup)) {
            throw new \Exception("Belirtilen id'de task group bulunamadı");
        }
        $tasks = TaskAssigned::where([
            'task_groups_id' => $id
        ])->orderBy('week')->get();
        return view('task.detail', ['developers' => $developers, 'tasks' => $tasks, 'taskGroup' => $taskGroup]);
    }
}
