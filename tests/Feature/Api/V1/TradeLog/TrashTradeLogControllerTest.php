<?php

use App\Application\TradeLog\UseCases\TrashTradeLog;
use App\Models\TradeLog as TradeLogModel;
use Mockery\MockInterface;

describe('Feature: TrashTradeLogController', function () {

    describe('Positives', function () {

        it('can trash existing trade log resource when using /api/v1/trade_logs/trash DELETE api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->deleteJson(sprintf('/api/v1/trade_logs/%s/trash', $trade_log->id));

            // Assert:
            $this->assertSoftDeleted($trade_log);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/trade_logs/trash DELETE api endpoint unauthenticated.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->deleteJson(sprintf('/api/v1/trade_logs/%s/trash', $trade_log->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/trade_logs/{trade_log}/trash DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->deleteJson(sprintf('/api/v1/trade_logs/%s/trash', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\TradeLog] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/trade_logs/{trade_log}/trash DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $trade_log = TradeLogModel::factory()->create();

            // Expectation:
            $this->mock(TrashTradeLog::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->deleteJson(sprintf('/api/v1/trade_logs/%s/trash', $trade_log->id));

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
