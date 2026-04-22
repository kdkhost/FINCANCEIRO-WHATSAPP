<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class PaymentGatewayAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'gateway',
        'label',
        'public_key',
        'secret_key',
        'webhook_secret',
        'settings',
        'is_active',
        'keys_encrypted',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
            'keys_encrypted' => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Encriptar chaves sensíveis
     */
    public function setPublicKeyAttribute(?string $value): void
    {
        $this->attributes['public_key'] = $value ? Crypt::encryptString($value) : null;
    }

    public function setSecretKeyAttribute(?string $value): void
    {
        $this->attributes['secret_key'] = $value ? Crypt::encryptString($value) : null;
    }

    public function setWebhookSecretAttribute(?string $value): void
    {
        $this->attributes['webhook_secret'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Descriptografar chaves sensíveis
     */
    public function getPublicKeyAttribute(?string $value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function getSecretKeyAttribute(?string $value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function getWebhookSecretAttribute(?string $value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }
}
