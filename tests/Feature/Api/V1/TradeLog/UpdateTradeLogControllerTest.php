<?php

use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Models\TradeLog as TradeLogModel;
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
                    'data' => [
                        'price' => $payload['price'],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/trade_logs/{trade_log} PUT api endpoint unauthenticated.', function () {
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
                ->assertJson([
                    'message' => 'Unauthenticated.',
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

        it('can handle server error response when using /api/v1/trade_logs PUT api endpoint.', function () {
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

});
