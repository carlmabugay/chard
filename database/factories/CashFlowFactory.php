<?php

namespace Database\Factories;

use App\Models\CashFlow;
use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CashFlow>
 */
class CashFlowFactory extends Factory
{
    protected $model = CashFlow::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'portfolio_id' => Portfolio::factory(),
            'type' => $this->faker->randomElement(['deposit', 'withdraw']),
            'amount' => $this->faker->randomFloat(2, 0, 9999),
        ];
    }
}
