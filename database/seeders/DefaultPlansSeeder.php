<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DefaultPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::where('slug', 'admin')->first();

        if (!$tenant) {
            $this->command->error('❌ Tenant admin não encontrado. Execute AdminUserSeeder primeiro.');
            return;
        }

        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Plano ideal para pequenos negócios que estão começando',
                'price' => 97.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Até 100 clientes',
                    '500 cobranças por mês',
                    '1 gateway de pagamento',
                    'WhatsApp automático',
                    'Suporte por email',
                    'Dashboard básico',
                ]),
                'limits' => json_encode([
                    'customers' => 100,
                    'invoices_per_month' => 500,
                    'gateways' => 1,
                    'whatsapp_messages' => 1000,
                ]),
                'is_active' => true,
                'tenant_id' => $tenant->id,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Plano completo para negócios em crescimento',
                'price' => 197.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Até 500 clientes',
                    '2.000 cobranças por mês',
                    '3 gateways de pagamento',
                    'WhatsApp automático',
                    'Templates personalizados',
                    'Suporte prioritário',
                    'API access',
                    'Relatórios avançados',
                ]),
                'limits' => json_encode([
                    'customers' => 500,
                    'invoices_per_month' => 2000,
                    'gateways' => 3,
                    'whatsapp_messages' => 5000,
                    'api_calls' => 10000,
                ]),
                'is_active' => true,
                'is_featured' => true,
                'tenant_id' => $tenant->id,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Solução completa para grandes empresas',
                'price' => 497.00,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Clientes ilimitados',
                    'Cobranças ilimitadas',
                    'Todos os gateways',
                    'WhatsApp dedicado',
                    'Customizações',
                    'Suporte 24/7',
                    'SLA garantido',
                    'Gerente dedicado',
                    'Treinamento personalizado',
                    'Integrações customizadas',
                ]),
                'limits' => json_encode([
                    'customers' => -1, // ilimitado
                    'invoices_per_month' => -1,
                    'gateways' => -1,
                    'whatsapp_messages' => -1,
                    'api_calls' => -1,
                ]),
                'is_active' => true,
                'tenant_id' => $tenant->id,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(
                [
                    'slug' => $planData['slug'],
                    'tenant_id' => $tenant->id,
                ],
                $planData
            );
        }

        $this->command->info('✅ Planos padrão criados com sucesso!');
        $this->command->info('📦 Starter: R$ 97,00/mês');
        $this->command->info('📦 Professional: R$ 197,00/mês');
        $this->command->info('📦 Enterprise: R$ 497,00/mês');
    }
}
