<?php

namespace Database\Factories;

use App\Models\Dividend;
use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class DividendFactory extends Factory
{
    protected $model = Dividend::class;

    public function definition(): array
    {
        return [
            'portfolio_id' => Portfolio::factory(),
            'symbol' => fake()->currencyCode(),
            'amount' => fake()->randomFloat(2, 40, 100000),
            'recorded_at' => fake()->date(),
        ];
    }
}
