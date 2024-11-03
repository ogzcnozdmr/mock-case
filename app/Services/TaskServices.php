<?php

namespace App\Services;

use Database\Factories\TaskFactory;

class TaskServices
{
    /**
     * @param array $array
     * @return array
     * @throws \Exception
     */
    public function getData(array $array) : array
    {
        $results = [];

        foreach ($array as $value) {
            //task factory servisinden verileri alır
            $adapter = TaskFactory::getTaskData($value);
            $results[] = $adapter->getData();
        }

        return $results;
    }
}
