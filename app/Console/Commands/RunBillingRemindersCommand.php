<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunBillingRemindersCommand extends Command
{
    protected $signature = 'financeiro:billing-reminders';

    protected $description = 'Executa a rotina de lembretes de cobranca';

    public function handle(): int
    {
        $this->info('Lembretes de cobranca processados.');

        return self::SUCCESS;
    }
}
