<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(array $array)
 */
class TaskData extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'task_datas';
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];
}
