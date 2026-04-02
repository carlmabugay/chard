<?php

use App\Application\TradeLog\UseCases\GetTradeLog;
use App\Models\TradeLog as TradeLogModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ShowTradeLogController', function () {

    describe('Positives', function () {
        it('should return a trade log resource when using /api/v1/trade-logs/{id} GET api endpoint.', function () {

            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            Sanctum::actingAs($trade_log->portfolio->user);
            $response = $this->get(sprintf('%s/%s', '/api/v1/trade-logs', $trade_log->id));

            // Assert:
            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'data' => [
                        'id' => $trade_log->id,
                        'symbol' => $trade_log->symbol,
                        'type' => $trade_log->type,
                        'price' => $trade_log->price,
                        'shares' => $trade_log->shares,
                        'fees' => $trade_log->fees,
                        'created_at' => $trade_log->created_at->toDateTimeString(),
                        'updated_at' => $trade_log->updated_at->toDateTimeString(),
                        'portfolio' => [
                            'id' => $trade_log->portfolio->id,
                            'name' => $trade_log->portfolio->name,
                            'created_at' => $trade_log->portfolio->created_at->toDateTimeString(),
                            'updated_at' => $trade_log->portfolio->updated_at->toDateTimeString(),
                        ],
                    ],
                ]);

        });

    });

    describe('Negatives', function () {

        it('should handle error message when no record found upon using /api/v1/trade-logs/{id} GET api endpoint.', function () {

            // Arrange:
            $random_id = 100;
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            Sanctum::actingAs($trade_log->portfolio->user);
            $response = $this->get(sprintf('/api/v1/trade-logs/%s', $random_id));

            // Assert:

            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Trade log not found',
                    'message' => sprintf('Trade log with ID: %s not found', $random_id),
                ]);

        });

        it('should handle server error response when using /api/v1/trade-logs/{id} GET api endpoint.', function () {

            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(GetTradeLog::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get(sprintf('/api/v1/trade-logs/%s', $random_id));

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
