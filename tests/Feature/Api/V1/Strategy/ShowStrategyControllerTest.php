<?php

use App\Application\Strategy\UseCases\GetStrategy;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ShowStrategyController', function () {

    describe('Positives', function () {

        it('can return a strategy resource when using /api/v1/strategies/{id} GET api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();
            Sanctum::actingAs($strategy->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/strategies/%s', $strategy->id));

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

        it('can handle error message when no record found upon using /api/v1/strategies/{id} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $strategy = StrategyModel::factory()->create();
            Sanctum::actingAs($strategy->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/strategies/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Strategy not found',
                    'message' => sprintf('Strategy with ID: %s not found', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/strategies/{id} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            // Expectation:
            $this->mock(GetStrategy::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->get(sprintf('/api/v1/strategies/%s', $random_id));

            // Assert:
            $response->assertInternalServerError()
                ->assertJson([
                    'success' => false,
                    'error' => 'An unexpected error occurred. Please try again later.',
                    'message' => 'This is a mock exception message.',
                ]);
        });

    });

});
