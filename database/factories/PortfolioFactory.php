<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
{
    protected $model = Portfolio::class;

    public function definition(): array
    {
        return [
            'user_id' => UserModel::factory(),
            'name' => fake()->company,
        ];
    }
}
