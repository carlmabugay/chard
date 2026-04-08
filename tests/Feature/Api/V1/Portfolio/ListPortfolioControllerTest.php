<?php

use App\Application\Portolio\UseCases\ListPortfolios;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: ListPortfolioController', function () {

    describe('Positives', function () {

        it('can return collection of portfolio resource when using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $no_of_portfolios = 5;
            $user = UserModel::factory()->create();

            PortfolioModel::factory($no_of_portfolios)->for($user)->create();

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/portfolios');

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.total', $no_of_portfolios);
        });

        it('can paginate portfolios when using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $no_of_portfolios = 50;
            $user = UserModel::factory()->create();

            PortfolioModel::factory($no_of_portfolios)->for($user)->create();

            $page_number = 2;
            $per_page = 10;

            $query = http_build_query([
                'page' => $page_number,
                'per_page' => $per_page,
            ]);

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/portfolios?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.current_page', $page_number)
                ->assertJsonCount($per_page, 'data');
        });

        it('can sort portfolios by created_at ascending when using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            PortfolioModel::factory()->for($user)->create(['created_at' => now()]);
            PortfolioModel::factory()->for($user)->create(['created_at' => now()->subDays(10)]);
            PortfolioModel::factory()->for($user)->create(['created_at' => now()->subDays(20)]);

            $query = http_build_query([
                'sorts' => [
                    ['field' => 'created_at', 'direction' => 'asc'],
                ],
            ]);

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/portfolios?%s', $query));

            $data = $response->json('data');

            // Assert:
            expect($data[0]['created_at'])->toBeLessThanOrEqual($data[1]['created_at']);
        });

        it('can search portfolios by name when using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            PortfolioModel::factory()->for($user)->create(['name' => 'Philippine Stock Market']);
            PortfolioModel::factory()->for($user)->create(['name' => 'Forex - London Session']);

            $query = http_build_query([
                'search' => 'session',
            ]);

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/portfolios?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.name', 'Forex - London Session');
        });

        it('can apply search, sort, and pagination together when using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            PortfolioModel::factory()->for($user)->create([
                'name' => 'Philippine Stock Market',
                'created_at' => now()->subDays(2),
            ]);

            PortfolioModel::factory()->for($user)->create([
                'name' => 'Forex - London Session',
                'created_at' => now(),
            ]);

            PortfolioModel::factory()->for($user)->create([
                'name' => 'Crypto - Alt Coins',
                'created_at' => now()->subDays(25),
            ]);

            $query = http_build_query([
                'search' => 'alt',
                'page' => 1,
                'per_page' => 1,
                'sorts' => [
                    ['field' => 'created_at', 'direction' => 'desc'],
                ],
            ]);

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/portfolios?%s', $query));

            // Assert
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.name', 'Crypto - Alt Coins');
        });

        it('can return empty data and 0 total record when no records found upon using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/portfolios');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/portfolios GET api endpoint unauthenticated.', function () {
            // Arrange:

            // Act:
            $response = $this->getJson('/api/v1/portfolios');

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);

        });

        it('can handle server error response when using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListPortfolios::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/portfolios');

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
