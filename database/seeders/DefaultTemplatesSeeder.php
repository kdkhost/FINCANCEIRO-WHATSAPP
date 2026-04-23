<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\WhatsappTemplate;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DefaultTemplatesSeeder extends Seeder
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

        // Email Templates
        $emailTemplates = [
            [
                'type' => 'billing_reminder',
                'name' => 'Lembrete de Cobrança',
                'subject' => 'Lembrete: Fatura {{invoice_code}} vence em {{days_until_due}} dias',
                'body' => '<p>Olá {{customer_name}},</p>
<p>Este é um lembrete de que sua fatura <strong>{{invoice_code}}</strong> no valor de <strong>R$ {{invoice_total}}</strong> vence em {{days_until_due}} dias.</p>
<p><strong>Data de Vencimento:</strong> {{invoice_due_date}}</p>
<p>Para evitar juros e multas, realize o pagamento até a data de vencimento.</p>
<p><a href="{{payment_url}}" style="background-color: #3B82F6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">Pagar Agora</a></p>
<p>Atenciosamente,<br>{{tenant_name}}</p>',
                'is_active' => true,
                'tenant_id' => $tenant->id,
            ],
            [
                'type' => 'overdue_invoice',
                'name' => 'Cobrança Vencida',
                'subject' => 'URGENTE: Fatura {{invoice_code}} está vencida',
                'body' => '<p>Olá {{customer_name}},</p>
<p>Sua fatura <strong>{{invoice_code}}</strong> no valor de <strong>R$ {{invoice_total}}</strong> está vencida desde {{invoice_due_date}}.</p>
<p>Para regularizar sua situação e evitar a suspensão dos serviços, realize o pagamento o quanto antes.</p>
<p><a href="{{payment_url}}" style="background-color: #EF4444; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">Pagar Agora</a></p>
<p>Em caso de dúvidas, entre em contato conosco.</p>
<p>Atenciosamente,<br>{{tenant_name}}</p>',
                'is_active' => true,
                'tenant_id' => $tenant->id,
            ],
            [
                'type' => 'payment_confirmation',
                'name' => 'Confirmação de Pagamento',
                'subject' => 'Pagamento Confirmado - Fatura {{invoice_code}}',
                'body' => '<p>Olá {{customer_name}},</p>
<p>Confirmamos o recebimento do pagamento da fatura <strong>{{invoice_code}}</strong> no valor de <strong>R$ {{invoice_total}}</strong>.</p>
<p><strong>Data do Pagamento:</strong> {{payment_date}}</p>
<p><strong>Método de Pagamento:</strong> {{payment_method}}</p>
<p>Obrigado pela sua preferência!</p>
<p>Atenciosamente,<br>{{tenant_name}}</p>',
                'is_active' => true,
                'tenant_id' => $tenant->id,
            ],
        ];

        foreach ($emailTemplates as $template) {
            EmailTemplate::firstOrCreate(
                [
                    'type' => $template['type'],
                    'tenant_id' => $tenant->id,
                ],
                $template
            );
        }

        // WhatsApp Templates
        $whatsappTemplates = [
            [
                'type' => 'billing_reminder',
                'name' => 'Lembrete de Cobrança',
                'body' => 'Olá *{{customer_name}}*! 👋

Este é um lembrete de que sua fatura *{{invoice_code}}* no valor de *R$ {{invoice_total}}* vence em {{days_until_due}} dias.

📅 *Vencimento:* {{invoice_due_date}}

Para pagar, acesse: {{payment_url}}

_{{tenant_name}}_',
                'is_active' => true,
                'tenant_id' => $tenant->id,
            ],
            [
                'type' => 'overdue_invoice',
                'name' => 'Cobrança Vencida',
                'body' => '⚠️ *URGENTE* ⚠️

Olá *{{customer_name}}*,

Sua fatura *{{invoice_code}}* no valor de *R$ {{invoice_total}}* está vencida desde {{invoice_due_date}}.

Para regularizar, acesse: {{payment_url}}

_{{tenant_name}}_',
                'is_active' => true,
                'tenant_id' => $tenant->id,
            ],
            [
                'type' => 'payment_confirmation',
                'name' => 'Confirmação de Pagamento',
                'body' => '✅ *Pagamento Confirmado!*

Olá *{{customer_name}}*,

Confirmamos o recebimento do pagamento da fatura *{{invoice_code}}* no valor de *R$ {{invoice_total}}*.

Obrigado! 🎉

_{{tenant_name}}_',
                'is_active' => true,
                'tenant_id' => $tenant->id,
            ],
        ];

        foreach ($whatsappTemplates as $template) {
            WhatsappTemplate::firstOrCreate(
                [
                    'type' => $template['type'],
                    'tenant_id' => $tenant->id,
                ],
                $template
            );
        }

        $this->command->info('✅ Templates padrão criados com sucesso!');
        $this->command->info('📧 3 templates de email');
        $this->command->info('💬 3 templates de WhatsApp');
    }
}
