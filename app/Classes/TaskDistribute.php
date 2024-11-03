<?php

namespace App\Classes;

use App\Classes\TaskDistribute\Developer;
use App\Classes\TaskDistribute\Task;
use App\Models\Developer as DeveloperModel;
use App\Models\Task as TaskModel;
use App\Models\TaskGroup as TaskGroupModel;
use Illuminate\Support\Facades\Log;

Class TaskDistribute
{
    /**
     * @var int
     */
    private int $taskGroupId;

    /**
     * @param int $taskGroupId
     */
    public function __construct(int $taskGroupId)
    {
        $this->taskGroupId = $taskGroupId;
    }

    /**
     * Taskları dağıtır
     * @return array
     */
    public function setTasks() : array
    {
        //task grubunu getiririr
        $taskGroupData = TaskGroupModel::where(['id' => $this->taskGroupId])->get();
        if ($taskGroupData->isEmpty()) {
            Log::error("Task bulunamadı id: {$this->taskGroupId}");
        }
        //bütün developerları getirir
        $developersData = DeveloperModel::get();
        //task verilerinin zorluklarını küçükten büyüğe doğru sıralayarak getirir
        $tasksData = TaskModel::where(['task_groups_id' => $this->taskGroupId])->orderBy('difficulty')->get();
        $developers = [];
        $tasks = [];
        //developerları oluşturur
        foreach($developersData as $data) {
            $developers[] = new Developer($data->id, $data->difficulty);
        }
        //taskları oluşturur
        foreach($tasksData as $data) {
            $tasks[] = new Task($data->id, $data->difficulty, $data->duration);
        }
        try {
            Log::info("Task başarıyla dağıtıldı, id: {$this->taskGroupId}");
            // Atama işlemini gerçekleştir
            return $this->assignTasks($developers, $tasks);
        } catch (\Exception) {
            //hatayı loga yazar
            Log::error("Task dağıtılamadı, id: {$this->taskGroupId}");
            return [];
        }
    }

    /**
     * Task atamaları yapar
     * @param array $developers
     * @param array $tasks
     * @return array
     */
    public function assignTasks(array $developers, array $tasks) : array
    {
        $assignments = [];

        foreach ($tasks as $task) {
            $taskEffort = $task->duration * $task->difficulty;
            //En Uygun developeri bulur
            $availableKey = $this->suitableDevelopersKey($developers, $taskEffort);
            //developerarın hiç birinin çözebilecek işi kalmadıysa
            if ($availableKey == -1) {
                //developerlar yeni haftaya geçer
                foreach ($developers as $developer) {
                    $developer->newWeek();
                }
                $availableKey = $this->suitableDevelopersKey($developers, $taskEffort);
                if ($availableKey == -1) {
                    Log::alert('Hiç bir developerin çözebileceği iş kalmadı');
                    return $assignments;
                }
            }
            $availableDevelopers = $developers[$availableKey];
            //taskın yukarı yuvarlanmış halde kaç saatte biteceği
            $developerDuration = ceil($taskEffort / $availableDevelopers->difficulty);
            //developer'in bu iş için vakti varsa
            if ($availableDevelopers->availableHour >= $developerDuration) {
                $assignments[] = [
                    'developerId' => $availableDevelopers->id,
                    'taskId' => $task->id,
                    'duration' => $developerDuration,
                    'week' => $availableDevelopers->week
                ];
                $availableDevelopers->availableHour -= $developerDuration;
            }
        }
        return $assignments;
    }

    /**
     * En Uygun developeri bulur
     * @param array $developers
     * @param int $taskEffort
     * @return int
     */
    private function suitableDevelopersKey(array $developers, int $taskEffort) : int
    {
        $key = -1;
        $availableHour = 0;
        $difficulty = 0;
        foreach($developers as $dKey => $developer) {
            //developerin kullanılabilir saati varsa
            if ($developer->availableHour > $availableHour) {
                $availableHour = $developer->availableHour;
                $difficulty = $developer->difficulty;
                $key = $dKey;
                //developerin kullanılabilir saati seçimdeki saate eşitse
            } else if ($developer->availableHour == $availableHour) {
                //developerin saatte bitirebileceği iş zorluğu eski developerdan yüksekse
                if ($developer->difficulty < $difficulty) {
                    $difficulty = $developer->difficulty;
                    $key = $dKey;
                }
            }
        }
        //kullanılabilir saat task için yeterli değilse
        if ($availableHour < ceil($taskEffort / $difficulty)) {
            $key = -1;
        }
        return $key;
    }
}
