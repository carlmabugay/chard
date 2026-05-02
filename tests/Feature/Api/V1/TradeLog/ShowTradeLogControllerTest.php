<?php

use App\Models\TradeLog as TradeLogModel;
use App\Models\User as UserModel;

describe('Feature: ShowTradeLogController', function () {

    describe('Positives', function () {

        it('can return a trade log resource when using /api/v1/trade_logs/{trade_log} GET api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->getJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id));

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
                        'created_at' => $trade_log->created_at->format('F d, Y'),
                        'updated_at' => $trade_log->updated_at->format('F d, Y'),
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/trade_logs/{trade_log} GET api endpoint.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->getJson(sprintf('/api/v1/trade_logs/%s', $trade_log->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/trade_logs/{trade_log} GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/trade_logs/%s', $other_trade_log->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/trade_logs/{trade_log} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $response = $this->actingAs($trade_log->portfolio->user)->getJson(sprintf('/api/v1/trade_logs/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\TradeLog] %s.', $random_id),
                ]);
        });

    });

});
