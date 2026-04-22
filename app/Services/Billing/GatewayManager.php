<?php

namespace App\Services\Billing;

use App\Contracts\Billing\GatewayContract;
use App\Services\Billing\Gateways\EfiGateway;
use App\Services\Billing\Gateways\MercadoPagoGateway;
use App\Services\Billing\Gateways\StripeGateway;
use InvalidArgumentException;

class GatewayManager
{
    public function driver(string $gateway): GatewayContract
    {
        return match ($gateway) {
            'mercadopago' => app(MercadoPagoGateway::class),
            'efi' => app(EfiGateway::class),
            'stripe' => app(StripeGateway::class),
            default => throw new InvalidArgumentException('Gateway nao suportado: '.$gateway),
        };
    }
}
