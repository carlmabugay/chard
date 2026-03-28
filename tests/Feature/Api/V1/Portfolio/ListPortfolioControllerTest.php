<?php

use App\Application\Portolio\UseCases\ListPortfolios;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ListPortfolioController', function () {

    describe('Positives', function () {

        it('should return collection of authenticated user\'s portfolio resource when using /api/v1/portfolios GET api endpoint.', function () {

            // Arrange:
            $no_of_portfolio = 5;
            $user = UserModel::factory()->create();

            PortfolioModel::factory()
                ->count($no_of_portfolio)
                ->for($user)
                ->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/portfolios');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [],
                ]);

        });

        it('should return empty data and 0 total record when no records found upon using /api/v1/portfolios GET api endpoint.', function () {

            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/portfolios');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [],
                ]);
        });

    });

    describe('Negatives', function () {

        it('should handle server error response when using /api/v1/portfolios GET api endpoint.', function () {

            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListPortfolios::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/portfolios');

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
