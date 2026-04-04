<?php

use App\Application\Portolio\UseCases\GetPortfolio;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ShowPortfolioController', function () {

    describe('Positives', function () {

        it('can return a portfolio resource when using /api/v1/portfolios/{id} GET api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/portfolios/%s', $portfolio->id));

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $portfolio->id,
                        'name' => $portfolio->name,
                        'created_at' => $portfolio->created_at,
                        'updated_at' => $portfolio->updated_at,
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can handle error message when no record found upon using /api/v1/portfolios/{id} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/portfolios/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Portfolio not found',
                    'message' => sprintf('Portfolio with ID: %s not found', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/portfolios/{id} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            // Expectation:
            $this->mock(GetPortfolio::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->get(sprintf('/api/v1/portfolios/%s', $random_id));

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
