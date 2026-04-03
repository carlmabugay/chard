<?php

use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Models\Portfolio as PortfolioModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: StoreTradeLogController', function () {

    describe('Positives', function () {

        it('should store new trade log resource when using /api/v1/trade-logs POST api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 100,
                'shares' => 1000,
                'fees' => 120,
            ];

            // Act:
            Sanctum::actingAs($portfolio->user);
            $response = $this->post('/api/v1/trade-logs', $payload);

            // Assert:
            $response->assertCreated()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'symbol' => $payload['symbol'],
                        'type' => $payload['type'],
                        'price' => $payload['price'],
                        'shares' => $payload['shares'],
                        'fees' => $payload['fees'],
                        'portfolio' => [
                            'id' => $payload['portfolio_id'],
                        ],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('should handle server error response when using /api/v1/trade-logs POST api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 100,
                'shares' => 1000,
                'fees' => 120,
            ];

            // Expectation:
            $this->mock(StoreTradeLog::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($portfolio->user);
            $response = $this->post('/api/v1/trade-logs', $payload);

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
