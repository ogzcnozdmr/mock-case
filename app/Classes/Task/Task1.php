<?php

namespace App\Classes\Task;

use App\Interfaces\TaskInterface;

class Task1 implements TaskInterface
{
    /**
     * @var array
     */
    private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->data = $data;
    }

    /**
     * Veriyi düzenler
     * @return array
     */
    public function getData(): array
    {
        return [
            'id' => $this->data['id'],
            'difficulty' => $this->data['value'],
            'duration' => $this->data['estimated_duration']
        ];
    }
}
