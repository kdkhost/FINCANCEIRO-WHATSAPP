<?php

return [
    'tasks' => [
        'system.health-check' => [
            'group' => 'Sistema',
            'label' => 'Verificacao de saude',
            'description' => 'Confere a operacao interna do scheduler e marca o sistema como operacional.',
            'command' => 'financeiro:cron-status',
            'frequency' => 'A cada minuto',
        ],
        'system.internal-runner' => [
            'group' => 'Sistema',
            'label' => 'Executor interno',
            'description' => 'Dispara o orquestrador principal das rotinas internas do SaaS.',
            'command' => 'financeiro:run-internal-cron',
            'frequency' => 'A cada minuto',
        ],
        'billing.reminders' => [
            'group' => 'Financeiro',
            'label' => 'Lembretes de cobranca',
            'description' => 'Prepara e dispara lembretes de faturas proximas do vencimento.',
            'command' => 'financeiro:billing-reminders',
            'frequency' => 'A cada 5 minutos',
        ],
        'messaging.dispatch' => [
            'group' => 'Mensageria',
            'label' => 'Fila de disparos',
            'description' => 'Executa a fila de WhatsApp e notificacoes pendentes.',
            'command' => 'financeiro:dispatch-messages',
            'frequency' => 'A cada minuto',
        ],
        'maintenance.cleanup' => [
            'group' => 'Manutencao',
            'label' => 'Limpeza e manutencao',
            'description' => 'Executa limpeza de arquivos temporarios e organizacao operacional.',
            'command' => 'financeiro:maintenance-cleanup',
            'frequency' => 'Diariamente',
        ],
    ],
];
