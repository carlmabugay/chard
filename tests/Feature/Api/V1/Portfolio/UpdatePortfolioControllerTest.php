<?php

use App\Application\Portolio\UseCases\StorePortfolio;
use App\Models\Portfolio as PortfolioModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: UpdatePortfolioController', function () {

    describe('Positives', function () {

        it('should update existing portfolio resource when using /api/v1/portfolios PUT api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'user_id' => $portfolio->user->id,
                'id' => $portfolio->id,
                'name' => 'PH Stock Market',
            ];

            // Act:
            Sanctum::actingAs($portfolio->user);
            $response = $this->put('/api/v1/portfolios', $payload);

            // Assert:
            $this->assertDatabaseHas('portfolios', $payload);

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

        it('should handle server error response when using /api/v1/portfolios PUT api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'user_id' => $portfolio->user->id,
                'id' => $portfolio->id,
                'name' => 'PH Stock Market',
            ];

            // Expectation:
            $this->mock(StorePortfolio::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($portfolio->user);
            $response = $this->put('/api/v1/portfolios', $payload);

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
