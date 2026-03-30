<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\TradeLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class TradeLogFactory extends Factory
{
    protected $model = TradeLog::class;

    public function definition(): array
    {
        return [
            'portfolio_id' => Portfolio::factory(),
            'symbol' => fake()->currencyCode(),
            'type' => fake()->randomElement(['buy', 'sell']),
            'price' => fake()->randomFloat(2, 10, 5000),
            'shares' => fake()->randomFloat(2, 10, 500000),
            'fees' => fake()->randomFloat(2, 10, 500000),
        ];
    }
}
