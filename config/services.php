<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Evolution GO (WhatsApp) Configuration
    |--------------------------------------------------------------------------
    |
    | Evolution GO é a versão em Golang da Evolution API para WhatsApp.
    | Mais rápida e eficiente, mantém compatibilidade com a API original.
    | Configure a URL da API, chave de autenticação e nome da instância.
    |
    | Documentação: https://github.com/EvolutionAPI/evolution-api
    |
    */

    'evolution' => [
        'url' => env('EVOLUTION_API_URL', 'http://localhost:8080'),
        'key' => env('EVOLUTION_API_KEY'),
        'instance_name' => env('EVOLUTION_INSTANCE_NAME'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    */

    'stripe' => [
        'public_key' => env('STRIPE_PUBLIC_KEY'),
        'secret_key' => env('STRIPE_SECRET_KEY'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | MercadoPago Configuration
    |--------------------------------------------------------------------------
    */

    'mercadopago' => [
        'access_token' => env('MERCADOPAGO_ACCESS_TOKEN'),
        'public_key' => env('MERCADOPAGO_PUBLIC_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Efi (Gerencianet) Configuration
    |--------------------------------------------------------------------------
    */

    'efi' => [
        'client_id' => env('EFI_CLIENT_ID'),
        'client_secret' => env('EFI_CLIENT_SECRET'),
        'webhook_secret' => env('EFI_WEBHOOK_SECRET'),
    ],
];
