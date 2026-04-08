<?php

use App\Application\Dividend\UseCases\StoreDividend;
use App\Models\Portfolio as PortfolioModel;
use Mockery\MockInterface;

describe('Feature: StoreCashFlowController', function () {

    describe('Positives', function () {

        it('can store new cash flow resource when using /api/v1/dividends POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'JFC',
                'amount' => 100,
                'recorded_at' => now()->toDateTimeString(),
            ];

            // Act:
            $result = $this->actingAs($portfolio->user)->post('/api/v1/dividends', $payload);

            // Assert:
            $result->assertCreated()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'symbol' => $payload['symbol'],
                        'amount' => $payload['amount'],
                        'recorded_at' => $payload['recorded_at'],
                        'portfolio' => [
                            'id' => $payload['portfolio_id'],
                        ],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can handle server error response when using /api/v1/dividends POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'JFC',
                'amount' => 100,
                'recorded_at' => now()->toDateTimeString(),
            ];

            // Expectation:
            $this->mock(StoreDividend::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($portfolio->user)->post('/api/v1/dividends', $payload);

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
