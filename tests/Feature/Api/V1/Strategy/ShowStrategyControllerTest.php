<?php

use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: ShowStrategyController', function () {

    describe('Positives', function () {

        it('should return a strategy resource when using /api/v1/strategies/{id} GET api endpoint.', function () {

            // Arrange:
            $user = UserModel::factory()->create();

            $strategy = StrategyModel::factory()
                ->for($user)
                ->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get(sprintf('%s/%s', '/api/v1/strategies', $strategy->id));

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $strategy->id,
                        'name' => $strategy->name,
                        'created_at' => $strategy->created_at,
                        'updated_at' => $strategy->updated_at,
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('should handle error message when no record found upon using /api/v1/strategies/{id} GET api endpoint.',
            function () {

                // Arrange:
                $random_id = 100;
                $user = UserModel::factory()->create();

                StrategyModel::factory()
                    ->for($user)
                    ->create();

                // Act:
                Sanctum::actingAs($user);
                $response = $this->get(sprintf('/api/v1/strategies/%s', $random_id));

                // Assert:

                $response->assertNotFound()
                    ->assertJson([
                        'success' => false,
                        'error' => 'Strategy not found',
                        'message' => sprintf('Strategy with ID: %s not found', $random_id),
                    ]);

            });

    });

});
