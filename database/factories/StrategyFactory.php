<?php

namespace Database\Factories;

use App\Models\Strategy;
use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class StrategyFactory extends Factory
{
    protected $model = Strategy::class;

    public function definition(): array
    {
        return [
            'user_id' => UserModel::factory(),
            'name' => fake()->company,
        ];
    }
}
