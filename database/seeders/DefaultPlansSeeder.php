<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class DefaultPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'price' => 97.00,
                'billing_cycle' => 'monthly',
                'trial_days' => 7,
                'features' => json_encode([
                    'customers' => 100,
                    'invoices_per_month' => 500,
                    'gateways' => 1,
                    'whatsapp_messages' => 1000,
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'price' => 197.00,
                'billing_cycle' => 'monthly',
                'trial_days' => 14,
                'features' => json_encode([
                    'customers' => 500,
                    'invoices_per_month' => 2000,
                    'gateways' => 3,
                    'whatsapp_messages' => 5000,
                    'api_calls' => 10000,
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 497.00,
                'billing_cycle' => 'monthly',
                'trial_days' => 30,
                'features' => json_encode([
                    'customers' => -1,
                    'invoices_per_month' => -1,
                    'gateways' => -1,
                    'whatsapp_messages' => -1,
                    'api_calls' => -1,
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }

        $this->command->info('✅ Planos padrão criados com sucesso!');
        $this->command->info('📦 Starter: R$ 97,00/mês');
        $this->command->info('📦 Professional: R$ 197,00/mês');
        $this->command->info('📦 Enterprise: R$ 497,00/mês');
    }
}
