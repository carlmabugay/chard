<?php

namespace Database\Factories;

use App\Models\Strategy;
use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Strategy>
 */
class StrategyFactory extends Factory
{
    protected $model = Strategy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserModel::factory(),
            'name' => fake()->company,
        ];
    }
}
