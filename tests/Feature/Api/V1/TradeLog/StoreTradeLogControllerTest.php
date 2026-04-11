<?php

use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Models\Portfolio as PortfolioModel;
use Mockery\MockInterface;

describe('Feature: StoreTradeLogController', function () {

    describe('Positives', function () {

        it('can store new trade log resource when using /api/v1/trade_logs POST api endpoint.', function () {
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
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertCreated()
                ->assertJson([
                    'success' => true,
                    'message' => __('messages.success.stored', ['record' => 'Trade log']),
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

        it('can return unauthenticated message when trying to access protected /api/v1/trade_logs POST api endpoint.', function () {
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
            $response = $this->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            $other_portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $other_portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 100,
                'shares' => 1000,
                'fees' => 120,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle server error response when using /api/v1/trade_logs POST api endpoint.', function () {
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
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertInternalServerError()
                ->assertJson([
                    'success' => false,
                    'error' => 'An unexpected error occurred. Please try again later.',
                    'message' => 'This is a mock exception message.',
                ]);
        });

    });

    describe('Validations', function () {

        it('requires portfolio id, symbol, type, price, shares, and fees fields when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'portfolio_id' => [__('validation.required', ['attribute' => 'portfolio id'])],
                        'symbol' => [__('validation.required', ['attribute' => 'symbol'])],
                        'type' => [__('validation.required', ['attribute' => 'type'])],
                        'price' => [__('validation.required', ['attribute' => 'price'])],
                        'shares' => [__('validation.required', ['attribute' => 'shares'])],
                        'fees' => [__('validation.required', ['attribute' => 'fees'])],
                    ],
                ]);
        });

        it('requires portfolio id field to exists when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => 100,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 100,
                'shares' => 1000,
                'fees' => 120,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'portfolio_id' => [__('validation.exists', ['attribute' => 'portfolio id'])],
                    ],
                ]);
        });

        it('requires type field to be valid when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'not-a-valid-type',
                'price' => 100,
                'shares' => 1000,
                'fees' => 120,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'type' => [__('validation.in', ['attribute' => 'type'])],
                    ],
                ]);
        });

        it('requires price field to be numeric when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 'not-a-valid-price',
                'shares' => 1000,
                'fees' => 120,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'price' => [__('validation.numeric', ['attribute' => 'price'])],
                    ],
                ]);
        });

        it('requires price field to be at least 1 when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 0,
                'shares' => 1000,
                'fees' => 120,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'price' => [__('validation.min.numeric', ['attribute' => 'price', 'min' => 1])],
                    ],
                ]);
        });

        it('requires shares field to be numeric when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 10,
                'shares' => 'not-a-valid-shares',
                'fees' => 120,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'shares' => [__('validation.numeric', ['attribute' => 'shares'])],
                    ],
                ]);
        });

        it('requires shares field to be at least 1 when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 100,
                'shares' => 0,
                'fees' => 120,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'shares' => [__('validation.min.numeric', ['attribute' => 'shares', 'min' => 1])],
                    ],
                ]);
        });

        it('requires fees field to be numeric when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 100,
                'shares' => 1000,
                'fees' => 'not-a-valid-fees',
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'fees' => [__('validation.numeric', ['attribute' => 'fees'])],
                    ],
                ]);
        });

        it('requires fees field to be at least 1 when using /api/v1/trade_logs POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'symbol' => 'BPI',
                'type' => 'buy',
                'price' => 100,
                'shares' => 1000,
                'fees' => 0,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/trade_logs', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'fees' => [__('validation.min.numeric', ['attribute' => 'fees', 'min' => 1])],
                    ],
                ]);
        });

    });

});
