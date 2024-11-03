<?php

namespace Database\Factories;

use App\Classes\Task\Task1;
use App\Classes\Task\Task2;
use App\Interfaces\TaskInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Exception;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{
    /**
     * @throws Exception
     */
    public static function getTaskData(array $data) : TaskInterface
    {
        if (isset($data['value'])) {
            return new Task1($data);
        } else if (isset($data['zorluk'])) {
            return new Task2($data);
        } else {
            throw new Exception("Veri türü desteklenmiyor");
        }
    }
    public function definition(){}
}
