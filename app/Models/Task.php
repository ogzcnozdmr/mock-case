<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(array $array)
 */
class Task extends Model
{
    use HasFactory;
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 'task_groups_id', 'task_datas_id', 'json_data_id', 'duration', 'difficulty'
    ];
}
