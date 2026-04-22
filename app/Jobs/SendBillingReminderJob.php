<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\EmailTemplate;
use App\Services\Messaging\TemplateRenderer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class SendBillingReminderJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $invoiceId
    ) {
    }

    public function handle(): void
    {
        $invoice = Invoice::with(['customer', 'tenant'])->find($this->invoiceId);

        if (!$invoice) {
            return;
        }

        // Não enviar lembretes para faturas já pagas ou canceladas
        if ($invoice->status === 'paid' || $invoice->status === 'cancelled') {
            return;
        }

        // Enviar por email
        $this->sendEmailReminder($invoice);

        // Enviar por WhatsApp se configurado
        if ($invoice->customer->phone) {
            SendWhatsappMessageJob::dispatch(
                $invoice->tenant_id,
                $invoice->customer->phone,
                $this->buildWhatsappMessage($invoice)
            );
        }

        // Registrar tentativa de envio
        $invoice->update([
            'reminder_sent_at' => now(),
            'reminder_count' => ($invoice->reminder_count ?? 0) + 1,
        ]);
    }

    private function sendEmailReminder(Invoice $invoice): void
    {
        $template = EmailTemplate::where('tenant_id', $invoice->tenant_id)
            ->where('type', 'billing_reminder')
            ->first();

        if (!$template) {
            return;
        }

        $renderer = new TemplateRenderer();
        $subject = $renderer->render($template->subject, [
            'invoice_code' => $invoice->code,
            'customer_name' => $invoice->customer->name,
            'due_date' => $invoice->due_date->format('d/m/Y'),
            'amount' => number_format($invoice->total, 2, ',', '.'),
        ]);

        $body = $renderer->render($template->body, [
            'invoice_code' => $invoice->code,
            'customer_name' => $invoice->customer->name,
            'due_date' => $invoice->due_date->format('d/m/Y'),
            'amount' => number_format($invoice->total, 2, ',', '.'),
            'payment_link' => route('invoice.pay', ['code' => $invoice->code]),
        ]);

        Mail::send([], [], function (Message $message) use ($invoice, $subject, $body) {
            $message->to($invoice->customer->email)
                ->subject($subject)
                ->html($body);
        });
    }

    private function buildWhatsappMessage(Invoice $invoice): string
    {
        $template = \App\Models\WhatsappTemplate::where('tenant_id', $invoice->tenant_id)
            ->where('type', 'billing_reminder')
            ->first();

        if (!$template) {
            return sprintf(
                "Olá %s, sua fatura #%s no valor de R$ %s vence em %s. Clique para pagar.",
                $invoice->customer->name,
                $invoice->code,
                number_format($invoice->total, 2, ',', '.'),
                $invoice->due_date->format('d/m/Y')
            );
        }

        $renderer = new TemplateRenderer();
        return $renderer->render($template->message, [
            'customer_name' => $invoice->customer->name,
            'invoice_code' => $invoice->code,
            'due_date' => $invoice->due_date->format('d/m/Y'),
            'amount' => number_format($invoice->total, 2, ',', '.'),
        ]);
    }
}
