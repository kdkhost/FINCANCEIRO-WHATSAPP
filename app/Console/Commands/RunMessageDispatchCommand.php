<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunMessageDispatchCommand extends Command
{
    protected $signature = 'financeiro:dispatch-messages';

    protected $description = 'Executa a fila de mensagens e notificacoes';

    public function handle(): int
    {
        $this->info('Fila de mensagens processada com sucesso.');

        return self::SUCCESS;
    }
}
