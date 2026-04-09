<?php

use App\Application\Strategy\UseCases\StoreStrategy;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: StoreStrategyController', function () {

    describe('Positives', function () {

        it('can store new strategy resource when using /api/v1/strategies POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'name' => 'Trend Following',
            ];

            // Act:
            $response = $this->actingAs($user)->postJson('/api/v1/strategies', $payload);

            // Assert:
            $response->assertCreated()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'name' => $payload['name'],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/strategies POST api endpoint unauthenticated.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'name' => 'Trend Following',
            ];

            // Act:
            $response = $this->postJson('/api/v1/strategies', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle server error response when using /api/v1/strategies POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'name' => 'Trend Following',
            ];

            // Expectation:
            $this->mock(StoreStrategy::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->postJson('/api/v1/strategies', $payload);

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
