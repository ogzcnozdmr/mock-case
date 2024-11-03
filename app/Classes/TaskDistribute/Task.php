<?php

namespace App\Classes\TaskDistribute;

class Task
{
    /**
     * @var int
     */
    public int $id;
    /**
     * @var int
     */
    public int $difficulty;
    /**
     * @var int
     */
    public int $duration;

    /**
     * @param int $id
     * @param int $difficulty
     * @param int $duration
     */
    public function __construct(int $id, int $difficulty, int $duration)
    {
        $this->id = $id;
        $this->difficulty = $difficulty;
        $this->duration = $duration;
    }
}

