<?php

use App\Application\Portolio\UseCases\StorePortfolio;
use App\Models\Portfolio as PortfolioModel;
use Mockery\MockInterface;

describe('Feature: UpdatePortfolioController', function () {

    describe('Positives', function () {

        it('can update existing portfolio resource when using /api/v1/portfolios PUT api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'user_id' => $portfolio->user->id,
                'id' => $portfolio->id,
                'name' => 'PH Stock Market',
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->put('/api/v1/portfolios', $payload);

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

        it('can handle server error response when using /api/v1/portfolios PUT api endpoint.', function () {
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
            $response = $this->actingAs($portfolio->user)->put('/api/v1/portfolios', $payload);

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
