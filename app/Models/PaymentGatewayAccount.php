<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewayAccount extends Model
{
    protected $fillable = [
        'tenant_id',
        'gateway',
        'label',
        'public_key',
        'secret_key',
        'webhook_secret',
        'settings',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
