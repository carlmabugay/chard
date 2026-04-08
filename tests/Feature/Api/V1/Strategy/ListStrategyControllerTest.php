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

        it('can paginate strategies when using /api/v1/strategies GET api endpoint.', function () {
            // Arrange:
            $no_of_strategies = 50;
            $user = UserModel::factory()->create();

            StrategyModel::factory($no_of_strategies)->for($user)->create();

            $page_number = 2;
            $per_page = 10;

            $query = http_build_query([
                'page' => $page_number,
                'per_page' => $per_page,
            ]);

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/strategies?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.current_page', $page_number)
                ->assertJsonCount($per_page, 'data');
        });

        it('can sort strategies by created_at ascending when using /api/v1/strategies GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            StrategyModel::factory()->for($user)->create(['created_at' => now()]);
            StrategyModel::factory()->for($user)->create(['created_at' => now()->subDays(10)]);
            StrategyModel::factory()->for($user)->create(['created_at' => now()->subDays(20)]);

            $query = http_build_query([
                'sorts' => [
                    ['field' => 'created_at', 'direction' => 'asc'],
                ],
            ]);

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/strategies?%s', $query));

            $data = $response->json('data');

            // Assert:
            expect($data[0]['created_at'])->toBeLessThanOrEqual($data[1]['created_at']);
        });

        it('can search strategies by name when using /api/v1/strategies GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            StrategyModel::factory()->for($user)->create(['name' => 'Momentum Strategy']);
            StrategyModel::factory()->for($user)->create(['name' => 'Mean Reversion']);

            $query = http_build_query([
                'search' => 'Momentum',
            ]);

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/strategies?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.name', 'Momentum Strategy');
        });

        it('can apply search, sort, and pagination together when using /api/v1/strategies GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            StrategyModel::factory()->for($user)->create([
                'name' => 'Momentum Strategy',
                'created_at' => now()->subDays(2),
            ]);

            StrategyModel::factory()->for($user)->create([
                'name' => 'Mean Reversion',
                'created_at' => now(),
            ]);

            StrategyModel::factory()->for($user)->create([
                'name' => 'Pull Back',
                'created_at' => now()->subDays(25),
            ]);

            $query = http_build_query([
                'search' => 'Pull',
                'page' => 1,
                'per_page' => 1,
                'sorts' => [
                    ['field' => 'created_at', 'direction' => 'desc'],
                ],
            ]);

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/strategies?%s', $query));

            // Assert
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.name', 'Pull Back');
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
