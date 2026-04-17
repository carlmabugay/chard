<?php

use App\Application\Strategy\UseCases\ListStrategies;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: ListStrategyController', function () {

    describe('Positives', function () {

        it('can return collection of strategy resource when using /api/v1/strategies GET api endpoint.', function () {
            // Arrange:
            $no_of_strategies = 5;
            $user = UserModel::factory()->create();

            StrategyModel::factory($no_of_strategies)->for($user)->create();

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/strategies');

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.total', $no_of_strategies);
        });

        it('can return empty data and 0 total record when no records found upon using /api/v1/strategies GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/strategies');

            // Assert:
            $response->assertOk()
                ->assertJsonCount(0, 'data');
        });
    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/strategies GET api endpoint.', function () {
            // Arrange:

            // Act:
            $response = $this->getJson('/api/v1/strategies');

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can handle server error response when using /api/v1/strategies GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListStrategies::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/strategies');

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
