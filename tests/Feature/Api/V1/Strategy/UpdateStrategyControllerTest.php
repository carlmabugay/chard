<?php

use App\Application\Strategy\UseCases\StoreStrategy;
use App\Models\Strategy as StrategyModel;
use Mockery\MockInterface;

describe('Feature: UpdateStrategyController', function () {

    describe('Positives', function () {

        it('can update existing strategy resource when using /api/v1/strategies PUT api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            $payload = [
                'user_id' => $strategy->user->id,
                'id' => $strategy->id,
                'name' => 'Pullback Trading',
            ];

            // Act:
            $response = $this->actingAs($strategy->user)->putJson('/api/v1/strategies', $payload);

            // Assert:
            $this->assertDatabaseHas('strategies', $payload);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'name' => $payload['name'],
                    ],
                ]);
        });
    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/strategies PUT api endpoint unauthenticated.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            $payload = [
                'user_id' => $strategy->user->id,
                'id' => $strategy->id,
                'name' => 'Pullback Trading',
            ];

            // Act:
            $response = $this->putJson('/api/v1/strategies', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle server error response when using /api/v1/strategies PUT api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            $payload = [
                'user_id' => $strategy->user->id,
                'id' => $strategy->id,
                'name' => 'Pullback Trading',
            ];

            // Expectation:
            $this->mock(StoreStrategy::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($strategy->user)->putJson('/api/v1/strategies', $payload);

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
