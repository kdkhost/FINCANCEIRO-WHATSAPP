<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CronExecution;
use App\Services\Cron\CronTaskRegistry;
use App\Services\Cron\CronTaskRunner;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class CronController extends Controller
{
    public function __construct(
        protected CronTaskRegistry $registry,
        protected CronTaskRunner $runner
    ) {
    }

    public function index(): View
    {
        $hasCronTable = Schema::hasTable('cron_executions');

        $latestExecutions = $hasCronTable
            ? CronExecution::query()->latest('started_at')->get()->keyBy('task_key')
            : collect();

        $groups = $this->registry->grouped()->map(function ($tasks) use ($latestExecutions) {
            return collect($tasks)->map(function (array $task) use ($latestExecutions): array {
                $task['last_execution'] = $latestExecutions->get($task['key']);

                return $task;
            });
        });

        $history = $hasCronTable
            ? CronExecution::query()->latest('started_at')->limit(20)->get()
            : new Collection();

        return view('admin.crons.index', compact('groups', 'history', 'hasCronTable'));
    }

    public function run(Request $request, string $taskKey): JsonResponse
    {
        if (! Schema::hasTable('cron_executions')) {
            return response()->json([
                'message' => 'Rode as migrations antes de executar os crons pelo painel.',
            ], 422);
        }

        $execution = $this->runner->run($taskKey, 'manual');

        return response()->json([
            'message' => 'Cron executado com sucesso.',
            'status' => $execution->status,
            'output' => $execution->output,
            'finished_at' => optional($execution->finished_at)?->format('d/m/Y H:i:s'),
        ]);
    }
}
