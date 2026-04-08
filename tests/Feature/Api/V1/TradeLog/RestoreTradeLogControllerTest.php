<?php

use App\Application\TradeLog\UseCases\RestoreTradeLog;
use App\Models\TradeLog as TradeLogModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: RestoreTradeLogController', function () {

    describe('Positives', function () {

        it('can restore trashed trade log resource when using /api/v1/trade-logs PATCH api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->patchJson(sprintf('/api/v1/trade-logs/%s', $trade_log->id));

            // Assert:
            $this->assertNotSoftDeleted($trade_log);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/trade-logs PATCH api endpoint unauthenticated.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->patchJson(sprintf('/api/v1/trade-logs/%s', $trade_log->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/trade-logs/{id} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->patchJson(sprintf('/api/v1/trade-logs/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Trade log not found.',
                    'message' => sprintf('Trade log with ID: [%s] not found.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/trade-logs/{id} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(RestoreTradeLog::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->patchJson(sprintf('/api/v1/trade-logs/%s', $random_id));

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
