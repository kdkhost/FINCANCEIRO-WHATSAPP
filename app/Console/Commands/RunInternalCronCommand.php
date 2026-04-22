<?php

namespace App\Console\Commands;

use App\Models\CronExecution;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunInternalCronCommand extends Command
{
    protected $signature = 'financeiro:run-internal-cron';

    protected $description = 'Executa rotinas internas do Financeiro Pro Whats';

    public function handle(): int
    {
        $startTime = now();
        $cronName = 'internal_cron';

        try {
            $this->info('Iniciando rotinas internas...');

            // 1. Atualizar status de faturas vencidas
            $this->updateOverdueInvoices();

            // 2. Limpar logs antigos
            $this->cleanOldLogs();

            // 3. Processar webhooks pendentes
            $this->processFailedWebhooks();

            $this->info('Cron interno executado com sucesso.');
            Log::info("Internal cron executed successfully");

            // Registrar execução bem-sucedida
            CronExecution::create([
                'name' => $cronName,
                'status' => 'success',
                'started_at' => $startTime,
                'finished_at' => now(),
                'output' => 'Internal cron executed successfully',
            ]);

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error running internal cron: {$e->getMessage()}");
            Log::error("Internal cron failed", [
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

    private function updateOverdueInvoices(): void
    {
        $count = Invoice::where('status', 'pending')
            ->whereDate('due_date', '<', now())
            ->update(['status' => 'overdue']);

        $this->info("Updated {$count} invoices to overdue status");
    }

    private function cleanOldLogs(): void
    {
        // Limpar logs de webhook com mais de 90 dias
        $count = \App\Models\WebhookLog::where('created_at', '<', now()->subDays(90))->delete();
        $this->info("Deleted {$count} old webhook logs");

        // Limpar execuções de cron com mais de 30 dias
        $count = CronExecution::where('created_at', '<', now()->subDays(30))->delete();
        $this->info("Deleted {$count} old cron executions");
    }

    private function processFailedWebhooks(): void
    {
        // Reprocessar webhooks que falharam (máximo 3 tentativas)
        $failedWebhooks = \App\Models\WebhookLog::where('status', 'failed')
            ->where('retry_count', '<', 3)
            ->where('created_at', '>', now()->subHours(24))
            ->get();

        foreach ($failedWebhooks as $webhook) {
            // Aqui você pode implementar a lógica de retry
            // Por enquanto, apenas incrementar o contador
            $webhook->increment('retry_count');
        }

        $this->info("Processed {$failedWebhooks->count()} failed webhooks");
    }
}
