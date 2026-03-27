<?php

use App\Application\Dividend\UseCases\ListDividends;
use App\Models\Dividend as DividendModel;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ListDividendController', function () {

    describe('Positives', function () {

        it('should return collection of authenticated user\'s dividend resource when using /api/v1/dividends GET api endpoint.', function () {

            // Arrange:
            $no_of_dividends = 5;
            $portfolio = PortfolioModel::factory()->create();
            DividendModel::factory()->count($no_of_dividends)->create([
                'portfolio_id' => $portfolio->id,
            ]);

            // Act:
            Sanctum::actingAs($portfolio->user);
            $response = $this->get('/api/v1/dividends');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [],
                ]);

        });

    });

    describe('Negatives', function () {

        it('should handle server error response when using /api/v1/dividends GET api endpoint.', function () {

            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListDividends::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/dividends');

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
