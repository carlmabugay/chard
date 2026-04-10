<?php

use App\Application\Strategy\UseCases\StoreStrategy;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: UpdateStrategyController', function () {

    describe('Positives', function () {

        it('can update existing strategy resource when using /api/v1/strategies/{strategy} PUT api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            $payload = [
                'name' => 'Pullback Trading',
            ];

            // Act:
            $response = $this->actingAs($strategy->user)->putJson(sprintf('/api/v1/strategies/%s', $strategy->id), $payload);

            // Assert:
            $this->assertDatabaseHas('strategies', $payload);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'message' => __('messages.success.updated', ['record' => 'Strategy']),
                    'data' => [
                        'name' => $payload['name'],
                    ],
                ]);
        });
    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/strategies/{strategy} PUT api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            $payload = [
                'name' => 'Pullback Trading',
            ];

            // Act:
            $response = $this->putJson(sprintf('/api/v1/strategies/%s', $strategy->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/strategies/{strategy} PUT api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->hasStrategies()->create();
            $other_strategy = StrategyModel::factory()->create();

            $payload = [
                'name' => 'Pullback Trading',
            ];

            // Act:
            $response = $this->actingAs($user)->putJson(sprintf('/api/v1/strategies/%s', $other_strategy->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/strategies/{strategy} PUT api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $strategy = StrategyModel::factory()->create();

            $payload = [
                'name' => 'Pullback Trading',
            ];

            // Act:
            $response = $this->actingAs($strategy->user)->putJson(sprintf('/api/v1/strategies/%s', $random_id), $payload);

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Strategy] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/strategies/{strategy} PUT api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            $payload = [
                'name' => 'Pullback Trading',
            ];

            // Expectation:
            $this->mock(StoreStrategy::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($strategy->user)->putJson(sprintf('/api/v1/strategies/%s', $strategy->id), $payload);

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
