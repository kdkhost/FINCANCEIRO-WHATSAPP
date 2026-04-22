<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('(##) #####-####'),
            'document_type' => fake()->randomElement(['cpf', 'cnpj']),
            'document_number' => fake()->numerify('##############'),
            'zipcode' => fake()->numerify('#####-###'),
            'address_line' => fake()->streetName(),
            'address_number' => (string) fake()->numberBetween(10, 999),
            'address_extra' => fake()->optional()->secondaryAddress(),
            'district' => fake()->citySuffix(),
            'city' => fake()->city(),
            'state' => fake()->stateAbbr(),
            'notes' => fake()->sentence(),
        ];
    }
}
