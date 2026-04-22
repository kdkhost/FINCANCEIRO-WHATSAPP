<?php

namespace App\Services\Cron;

use Illuminate\Support\Collection;

class CronTaskRegistry
{
    public function all(): Collection
    {
        return collect(config('cron-panel.tasks', []));
    }

    public function grouped(): Collection
    {
        return $this->all()
            ->map(function (array $task, string $key): array {
                $task['key'] = $key;

                return $task;
            })
            ->groupBy('group');
    }

    public function get(string $taskKey): ?array
    {
        $task = config("cron-panel.tasks.{$taskKey}");

        if (! is_array($task)) {
            return null;
        }

        $task['key'] = $taskKey;

        return $task;
    }
}
