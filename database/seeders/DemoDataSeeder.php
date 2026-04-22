<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\PaymentGatewayAccount;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        Plan::query()->delete();
        PaymentGatewayAccount::query()->delete();
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
