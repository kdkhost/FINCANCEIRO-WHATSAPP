<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\WebhookLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsappMessageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $tenantId,
        public string $phone,
        public string $message
    ) {
    }

    public function handle(): void
    {
        $tenant = Tenant::find($this->tenantId);

        if (!$tenant) {
            Log::warning("Tenant {$this->tenantId} not found for WhatsApp message");
            return;
        }

        // Validar se Evolution API está configurada
        $evolutionUrl = config('services.evolution.url');
        $evolutionKey = config('services.evolution.key');
        $instanceName = config('services.evolution.instance_name');

        if (!$evolutionUrl || !$evolutionKey || !$instanceName) {
            Log::warning("Evolution API not configured for tenant {$this->tenantId}");
            return;
        }

        try {
            // Normalizar número de telefone (remover caracteres especiais)
            $phone = preg_replace('/[^0-9]/', '', $this->phone);

            // Enviar mensagem via Evolution API
            $response = Http::withHeaders([
                'apikey' => $evolutionKey,
                'Content-Type' => 'application/json',
            ])->post("{$evolutionUrl}/message/sendText/{$instanceName}", [
                'number' => $phone,
                'text' => $this->message,
            ]);

            // Registrar log do webhook
            WebhookLog::create([
                'tenant_id' => $this->tenantId,
                'type' => 'whatsapp_message',
                'status' => $response->successful() ? 'success' : 'failed',
                'request_data' => [
                    'phone' => $phone,
                    'message' => $this->message,
                ],
                'response_data' => $response->json(),
                'response_code' => $response->status(),
            ]);

            if (!$response->successful()) {
                Log::error("Failed to send WhatsApp message", [
                    'tenant_id' => $this->tenantId,
                    'phone' => $phone,
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error sending WhatsApp message: {$e->getMessage()}", [
                'tenant_id' => $this->tenantId,
                'phone' => $this->phone,
                'exception' => $e,
            ]);

            WebhookLog::create([
                'tenant_id' => $this->tenantId,
                'type' => 'whatsapp_message',
                'status' => 'error',
                'request_data' => [
                    'phone' => $this->phone,
                    'message' => $this->message,
                ],
                'response_data' => ['error' => $e->getMessage()],
                'response_code' => 500,
            ]);
        }
    }
}
