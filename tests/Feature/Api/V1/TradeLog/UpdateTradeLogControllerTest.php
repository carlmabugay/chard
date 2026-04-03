<?php

use App\Models\TradeLog as TradeLogModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: UpdateTradeLogController', function () {

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
