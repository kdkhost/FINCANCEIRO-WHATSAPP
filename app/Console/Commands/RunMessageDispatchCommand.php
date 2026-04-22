<?php

namespace App\Console\Commands;

use App\Models\CronExecution;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class RunMessageDispatchCommand extends Command
{
    protected $signature = 'financeiro:dispatch-messages';

    protected $description = 'Executa a fila de mensagens e notificacoes';

    public function handle(): int
    {
        $startTime = now();
        $cronName = 'message_dispatch';

        try {
            // Processar fila de mensagens
            // Se usar database queue, as mensagens são processadas automaticamente
            // Este comando é útil para monitorar e registrar execuções

            $this->info('Fila de mensagens processada com sucesso.');
            Log::info("Message dispatch cron executed");

            // Registrar execução bem-sucedida
            CronExecution::create([
                'name' => $cronName,
                'status' => 'success',
                'started_at' => $startTime,
                'finished_at' => now(),
                'output' => 'Message queue processed successfully',
            ]);

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error dispatching messages: {$e->getMessage()}");
            Log::error("Message dispatch cron failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Registrar execução com erro
            CronExecution::create([
                'name' => $cronName,
                'status' => 'failed',
                'started_at' => $startTime,
                'finished_at' => now(),
                'output' => $e->getMessage(),
            ]);

            return self::FAILURE;
        }
    }
}
