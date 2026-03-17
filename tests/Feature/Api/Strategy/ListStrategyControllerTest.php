<?php

use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: ListPortfolioController', function () {

    it('should return collection of authenticated user\'s strategy resource when using /api/v1/strategies GET api endpoint.',
        function () {

            // Arrange:
            $no_of_strategy = 5;
            $user = UserModel::factory()->create();

            StrategyModel::factory()
                ->count($no_of_strategy)
                ->for($user)
                ->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/strategies');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [],
                    'total' => $no_of_strategy,
                ]);

        });

});
