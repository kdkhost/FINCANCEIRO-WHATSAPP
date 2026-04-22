<?php

namespace Database\Factories;

use App\Models\PaymentGatewayAccount;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentGatewayAccountFactory extends Factory
{
    protected $model = PaymentGatewayAccount::class;

    public function definition(): array
    {
        $gateway = fake()->randomElement(['mercadopago', 'efi', 'stripe']);

        return [
            'tenant_id' => Tenant::factory(),
            'gateway' => $gateway,
            'label' => strtoupper($gateway).' Principal',
            'public_key' => 'pub_'.Str::lower(Str::random(18)),
            'secret_key' => 'sec_'.Str::lower(Str::random(32)),
            'webhook_secret' => 'wh_'.Str::lower(Str::random(20)),
            'settings' => [
                'sandbox' => true,
                'transparent_checkout' => true,
                'pix' => true,
                'boleto' => true,
                'card' => true,
            ],
            'is_active' => true,
        ];
    }
}
