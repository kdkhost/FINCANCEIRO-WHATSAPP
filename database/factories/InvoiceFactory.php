<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'customer_id' => Customer::factory(),
            'code' => 'FAT-'.Str::upper(fake()->bothify('####??')),
            'status' => fake()->randomElement(['draft', 'pending', 'paid', 'overdue']),
            'description' => fake()->sentence(),
            'due_date' => now()->addDays(fake()->numberBetween(-10, 20)),
            'total' => fake()->randomFloat(2, 89, 2890),
            'gateway' => fake()->randomElement(['mercadopago', 'efi', 'stripe']),
            'payment_url' => fake()->url(),
            'external_reference' => Str::upper(fake()->bothify('REF####??')),
        ];
    }
}
