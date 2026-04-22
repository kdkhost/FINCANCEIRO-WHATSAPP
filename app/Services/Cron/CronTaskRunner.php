<?php

namespace App\Services\Cron;

use App\Models\CronExecution;
use Illuminate\Support\Facades\Artisan;
use Throwable;

class CronTaskRunner
{
    public function __construct(
        protected CronTaskRegistry $registry
    ) {
    }

    public function run(string $taskKey, string $triggeredBy = 'scheduler'): CronExecution
    {
        $task = $this->registry->get($taskKey);

        if (! $task) {
            abort(404, 'Tarefa de cron nao encontrada.');
        }

        $execution = CronExecution::query()->create([
            'task_key' => $taskKey,
            'group_name' => $task['group'],
            'command' => $task['command'],
            'triggered_by' => $triggeredBy,
            'status' => 'running',
            'started_at' => now(),
        ]);

        try {
            $exitCode = Artisan::call($task['command']);

            $execution->update([
                'status' => $exitCode === 0 ? 'success' : 'failed',
                'output' => trim(Artisan::output()),
                'finished_at' => now(),
            ]);
        } catch (Throwable $exception) {
            $execution->update([
                'status' => 'failed',
                'output' => $exception->getMessage(),
                'finished_at' => now(),
            ]);
        }

        return $execution->fresh();
    }
}
