<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\TaskData;
use App\Models\TaskGroup;
use App\Services\TaskServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TaskFetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Taskları oluşturur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //içe aktaracağımız mock data task url'leri
        $urls = [
            '/data/task/1',
            '/data/task/2'
        ];
        //task grubu oluşturulur
        $taskGroupId = TaskGroup::create([
            'name' => 'Task Group 1'
        ])->id;
        foreach ($urls as $url) {
            $response = Http::get(url($url));
            $result = $response->json();

            //task verisi içe aktarım grubu oluşur
            $taskDatasId = TaskData::create([
                'name' => $result['name'],
            ])->id;

            $taskServices = app(TaskServices::class);
            //verileri adapter'a göre işler ve alır
            $tasks = $taskServices->getData($result['data']);
            foreach ($tasks as $item) {
                try {
                    //taskı oluşturur
                    Task::create([
                        'json_data_id' => $item['id'],
                        'task_groups_id' => $taskGroupId,
                        'task_datas_id' => $taskDatasId,
                        'duration' => $item['duration'],
                        'difficulty' => $item['difficulty']
                    ]);
                    Log::info("Task oluşturuldu id: " . $item['id']);
                } catch (\Exception) {
                    Log::error("Task oluşturulamadı id: " . $item['id']);
                }
            }
        }
    }
}
