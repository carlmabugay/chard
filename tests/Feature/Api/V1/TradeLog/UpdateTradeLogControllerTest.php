<?php

use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Models\TradeLog as TradeLogModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: UpdateTradeLogController', function () {

    describe('Positives', function () {

        it('can update existing trade log resource when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => 110,
                'shares' => $trade_log->shares,
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $this->assertDatabaseHas('trade_logs', $payload);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'message' => __('messages.success.updated', ['record' => 'Trade log']),
                    'data' => [
                        'price' => $payload['price'],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => 110,
                'shares' => $trade_log->shares,
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $other_trade_log->portfolio->id,
                'symbol' => $other_trade_log->symbol,
                'type' => $other_trade_log->type,
                'price' => 110,
                'shares' => $other_trade_log->shares,
                'fees' => $other_trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($user)->putJson(sprintf('/api/v1/trade_logs/%s', $other_trade_log->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => 110,
                'shares' => $trade_log->shares,
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $random_id), $payload);

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\TradeLog] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => 110,
                'shares' => $trade_log->shares,
                'fees' => $trade_log->fees,
            ];

            // Expectation:
            $this->mock(StoreTradeLog::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

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

        it('requires symbol, type, price, shares, and fees fields when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'symbol' => [__('validation.required', ['attribute' => 'symbol'])],
                        'type' => [__('validation.required', ['attribute' => 'type'])],
                        'price' => [__('validation.required', ['attribute' => 'price'])],
                        'shares' => [__('validation.required', ['attribute' => 'shares'])],
                        'fees' => [__('validation.required', ['attribute' => 'fees'])],
                    ],
                ]);
        });

        it('requires portfolio id field to exists when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => 100,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => $trade_log->price,
                'shares' => $trade_log->shares,
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'portfolio_id' => [__('validation.exists', ['attribute' => 'portfolio id'])],
                    ],
                ]);
        });

        it('requires type field to be valid when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => 'not-a-valid-type',
                'price' => $trade_log->price,
                'shares' => $trade_log->shares,
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'type' => [__('validation.in', ['attribute' => 'type'])],
                    ],
                ]);
        });

        it('requires price field to be numeric when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => 'not-a-valid-price',
                'shares' => $trade_log->shares,
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'price' => [__('validation.numeric', ['attribute' => 'price'])],
                    ],
                ]);
        });

        it('requires price field to be at least 1 when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => 0,
                'shares' => $trade_log->shares,
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'price' => [__('validation.min.numeric', ['attribute' => 'price', 'min' => 1])],
                    ],
                ]);
        });

        it('requires shares field to be numeric when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => $trade_log->price,
                'shares' => 'not-a-valid-shares',
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'shares' => [__('validation.numeric', ['attribute' => 'shares'])],
                    ],
                ]);
        });

        it('requires shares field to be at least 1 when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => $trade_log->price,
                'shares' => 0,
                'fees' => $trade_log->fees,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'shares' => [__('validation.min.numeric', ['attribute' => 'shares', 'min' => 1])],
                    ],
                ]);
        });

        it('requires fees field to be numeric when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => $trade_log->price,
                'shares' => $trade_log->shares,
                'fees' => 'not-a-valid-fees',
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'fees' => [__('validation.numeric', ['attribute' => 'fees'])],
                    ],
                ]);
        });

        it('requires fees field to be at least 1 when using /api/v1/trade_logs/{trade_log} PUT api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            $payload = [
                'portfolio_id' => $trade_log->portfolio->id,
                'symbol' => $trade_log->symbol,
                'type' => $trade_log->type,
                'price' => $trade_log->price,
                'shares' => $trade_log->shares,
                'fees' => 0,
            ];

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->putJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id), $payload);

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
