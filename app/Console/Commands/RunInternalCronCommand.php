<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunInternalCronCommand extends Command
{
    protected $signature = 'financeiro:run-internal-cron';

    protected $description = 'Executa rotinas internas do Financeiro Pro Whats';

    public function handle(): int
    {
        $this->info('Cron interno executado com sucesso.');

        return self::SUCCESS;
    }
}
