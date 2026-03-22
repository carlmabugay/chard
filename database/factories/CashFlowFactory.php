<?php

namespace Database\Factories;

use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashFlowFactory extends Factory
{
    protected $model = CashFlow::class;

    public function definition(): array
    {
        return [
            'portfolio_id' => Portfolio::factory(),
            'type' => fake()->randomElement(CashFlowType::values()),
            'amount' => fake()->randomFloat(2, 1, 9999),
        ];
    }
}
