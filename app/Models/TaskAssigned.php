<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(array $array)
 */
class TaskAssigned extends Model
{
    use HasFactory;
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'task_groups_id', 'tasks_id', 'developers_id', 'duration', 'week'
    ];
}
