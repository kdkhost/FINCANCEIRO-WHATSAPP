<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronExecution extends Model
{
    protected $fillable = [
        'task_key',
        'group_name',
        'command',
        'triggered_by',
        'status',
        'output',
        'started_at',
        'finished_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }
}
