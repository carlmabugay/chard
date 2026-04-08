<?php

use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Models\Portfolio as PortfolioModel;
use Mockery\MockInterface;

describe('Feature: StoreTradeLogController', function () {

    describe('Positives', function () {

        it('can store new trade log resource when using /api/v1/trade-logs POST api endpoint.', function () {
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
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade-logs', $payload);

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

        it('can return unauthorized message when trying to access protected /api/v1/trade-logs POST api endpoint unauthenticated.', function () {
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
            $response = $this->postJson('/api/v1/trade-logs', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle server error response when using /api/v1/trade-logs POST api endpoint.', function () {
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
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade-logs', $payload);

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
