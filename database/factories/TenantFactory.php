<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        $company = fake()->unique()->company();
        $slug = Str::slug($company);

        return [
            'uuid' => (string) Str::uuid(),
            'name' => $company,
            'slug' => $slug,
            'primary_domain' => $slug.'.demo.local',
            'status' => fake()->randomElement(['trial', 'active']),
            'trial_ends_at' => now()->addDays(fake()->numberBetween(5, 20)),
            'subscription_ends_at' => now()->addDays(fake()->numberBetween(30, 120)),
        ];
    }
}
