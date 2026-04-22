<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\EmailTemplate;
use App\Models\Invoice;
use App\Models\PaymentGatewayAccount;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use App\Models\WhatsappTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        Plan::query()->delete();
        PaymentGatewayAccount::query()->delete();
        EmailTemplate::query()->delete();
        WhatsappTemplate::query()->delete();
        Invoice::query()->delete();
        Customer::query()->delete();
        User::query()->delete();
        Tenant::query()->delete();

        Plan::factory()->count(3)->create();

        User::factory()->saasAdmin()->create([
            'password' => 'password',
        ]);

        Tenant::factory()
            ->count(4)
            ->create()
            ->each(function (Tenant $tenant): void {
                User::factory()->count(3)->create([
                    'tenant_id' => $tenant->id,
                ]);

                collect(['mercadopago', 'efi', 'stripe'])->each(function (string $gateway) use ($tenant): void {
                    PaymentGatewayAccount::factory()->create([
                        'tenant_id' => $tenant->id,
                        'gateway' => $gateway,
                        'label' => strtoupper($gateway).' '.$tenant->name,
                    ]);
                });

                WhatsappTemplate::query()->create([
                    'tenant_id' => $tenant->id,
                    'type' => 'invoice_due',
                    'name' => 'Aviso de vencimento',
                    'body' => 'Ola {{nome}}, sua fatura de {{valor}} vence em {{data_vencimento}}. Pague agora: {{link_pagamento}}',
                    'is_active' => true,
                ]);

                EmailTemplate::query()->create([
                    'tenant_id' => $tenant->id,
                    'type' => 'invoice_due',
                    'name' => 'Aviso de vencimento',
                    'subject' => 'Sua fatura vence em {{data_vencimento}}',
                    'body' => '<p>Ola {{nome}},</p><p>Sua fatura de <strong>{{valor}}</strong> esta proxima do vencimento.</p><p>Acesse: {{link_pagamento}}</p>',
                    'is_active' => true,
                ]);

                $customers = Customer::factory()
                    ->count(8)
                    ->create([
                        'tenant_id' => $tenant->id,
                    ]);

                $customers->each(function (Customer $customer) use ($tenant): void {
                    Invoice::factory()->count(2)->create([
                        'tenant_id' => $tenant->id,
                        'customer_id' => $customer->id,
                        'code' => 'FAT-'.Str::upper(fake()->bothify('##??##')),
                    ]);
                });
            });
    }
}
