<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('(##) #####-####'),
            'email_verified_at' => now(),
            'password' => 'password',
            'is_saas_admin' => false,
            'two_factor_enabled' => fake()->boolean(30),
            'webauthn_enabled' => fake()->boolean(20),
            'last_login_at' => now()->subDays(fake()->numberBetween(0, 15)),
            'remember_token' => Str::random(10),
        ];
    }

    public function saasAdmin(): static
    {
        return $this->state(fn () => [
            'tenant_id' => null,
            'is_saas_admin' => true,
            'email' => 'admin@financeiroprowhats.test',
            'name' => 'Administrador SaaS',
        ]);
    }
}
