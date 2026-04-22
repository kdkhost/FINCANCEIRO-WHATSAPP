<?php

namespace App\Console\Commands;

use App\Jobs\SendBillingReminderJob;
use App\Models\Invoice;
use App\Models\CronExecution;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunBillingRemindersCommand extends Command
{
    protected $signature = 'financeiro:billing-reminders';

    protected $description = 'Executa a rotina de lembretes de cobranca';

    public function handle(): int
    {
        $startTime = now();
        $cronName = 'billing_reminders';

        try {
            // Encontrar faturas que vencem nos próximos 3 dias e ainda não foram lembradas
            $invoices = Invoice::where('status', 'pending')
                ->whereDate('due_date', '<=', now()->addDays(3))
                ->whereDate('due_date', '>=', now())
                ->where(function ($query) {
                    $query->whereNull('reminder_sent_at')
                        ->orWhere('reminder_count', '<', 3); // Máximo 3 lembretes
                })
                ->get();

            $count = 0;
            foreach ($invoices as $invoice) {
                SendBillingReminderJob::dispatch($invoice->id);
                $count++;
            }

            $this->info("Lembretes de cobranca processados. {$count} jobs despachados.");
            Log::info("Billing reminders cron executed", ['count' => $count]);

            // Registrar execução bem-sucedida
            CronExecution::create([
                'name' => $cronName,
                'status' => 'success',
                'started_at' => $startTime,
                'finished_at' => now(),
                'output' => "Dispatched {$count} billing reminder jobs",
            ]);

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error running billing reminders: {$e->getMessage()}");
            Log::error("Billing reminders cron failed", [
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
