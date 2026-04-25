<?php

use App\Domain\Strategy\Processes\CreateStrategyProcess;
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
            $this->assertDatabaseHas('strategies', $payload);

            $response->assertCreated()
                ->assertJson([
                    'success' => true,
                    'message' => __('messages.success.stored', ['record' => 'Strategy']),
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/strategies POST api endpoint.', function () {
            // Arrange:
            $payload = [
                'name' => 'Trend Following',
            ];

            // Act:
            $response = $this->postJson('/api/v1/strategies', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can handle server error response when using /api/v1/strategies POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'name' => 'Trend Following',
            ];

            // Expectation:
            $this->mock(CreateStrategyProcess::class, function (MockInterface $mock) {
                $mock->shouldReceive('run')
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

    describe('Validations', function () {

        it('requires name field when using /api/v1/strategies POST api endpoint.', function () {

            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [];

            // Act:
            $response = $this->actingAs($user)->postJson('/api/v1/strategies', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertExactJson([
                    'message' => __('validation.required', ['attribute' => 'name']),
                    'errors' => [
                        'name' => [
                            0 => __('validation.required', ['attribute' => 'name']),
                        ],
                    ],
                ]);

        });

        it('limits name field to 255 characters when using /api/v1/strategies POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'name' => fake()->text(500),
            ];

            // Act:
            $response = $this->actingAs($user)->postJson('/api/v1/strategies', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertExactJson([
                    'message' => __('validation.max.string', ['attribute' => 'name', 'max' => 255]),
                    'errors' => [
                        'name' => [
                            0 => __('validation.max.string', ['attribute' => 'name', 'max' => 255]),
                        ],
                    ],
                ]);
        });

    });

});
