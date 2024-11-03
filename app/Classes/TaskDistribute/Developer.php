<?php

namespace App\Classes\TaskDistribute;

class Developer
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
    public int $availableHour;
    /**
     * @var int
     */
    public int $week = 1;
    /**
     * @param int $id
     * @param int $difficulty
     * @param int $availableHour
     */
    public function __construct(int $id, int $difficulty, int $availableHour = 45)
    {
        $this->id = $id;
        $this->difficulty = $difficulty;
        $this->availableHour = $availableHour;
    }

    /**
     * Haftayı yeniler
     * @return void
     */
    public function newWeek(): void
    {
        $this->week += 1;
        $this->availableHour = 45;
    }
}
