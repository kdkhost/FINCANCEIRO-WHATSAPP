<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        $name = fake()->randomElement([
            'Start',
            'Pro',
            'Scale',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->unique()->numerify('##')),
            'price' => fake()->randomFloat(2, 79, 499),
            'billing_cycle' => fake()->randomElement(['monthly', 'quarterly', 'yearly']),
            'trial_days' => fake()->randomElement([7, 14, 30]),
            'features' => [
                'whatsapp' => true,
                'crm' => true,
                'contracts' => true,
                'analytics' => fake()->boolean(),
            ],
            'is_active' => true,
        ];
    }
}
