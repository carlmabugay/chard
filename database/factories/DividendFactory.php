<?php

namespace Database\Factories;

use App\Models\Dividend;
use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dividend>
 */
class DividendFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'portfolio_id' => Portfolio::factory(),
            'symbol' => $this->faker->currencyCode(),
            'amount' => fake()->randomFloat(2, 40, 100000),
            'recorded_at' => fake()->date(),
        ];
    }
}
