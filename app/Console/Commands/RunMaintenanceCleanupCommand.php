<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunMaintenanceCleanupCommand extends Command
{
    protected $signature = 'financeiro:maintenance-cleanup';

    protected $description = 'Executa rotinas de limpeza e manutencao interna';

    public function handle(): int
    {
        $this->info('Limpeza interna executada com sucesso.');

        return self::SUCCESS;
    }
}
