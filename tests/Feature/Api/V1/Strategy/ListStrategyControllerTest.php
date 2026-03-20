<?php

use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: ListStrategyController', function () {

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

    it('should return empty data and 0 total record when no records found upon using /api/v1/strategies GET api endpoint.',
        function () {

            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/strategies');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [],
                    'total' => 0,
                ]);
        });
});
