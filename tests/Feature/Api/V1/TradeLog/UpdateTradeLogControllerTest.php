<?php

use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Models\TradeLog as TradeLogModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: UpdateTradeLogController', function () {

    describe('Positives', function () {

        it('should update existing trade log resource when using /api/v1/trade-logs PUT api endpoint.', function () {

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
            Sanctum::actingAs($trade_log->portfolio->user);
            $response = $this->put('/api/v1/trade-logs', $payload);

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

        it('should handle server error response when using /api/v1/trade-logs PUT api endpoint.', function () {

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
            Sanctum::actingAs($trade_log->portfolio->user);
            $response = $this->put('/api/v1/trade-logs', $payload);

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
