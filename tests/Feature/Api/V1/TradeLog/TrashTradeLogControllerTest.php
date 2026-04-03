<?php

use App\Models\TradeLog as TradeLogModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: TrashTradeLogController', function () {

    it('should trash existing trade log resource when using /api/v1/trade-logs DELETE api endpoint.', function () {

        // Arrange:
        $trade_log = TradeLogModel::factory()->create();

        Sanctum::actingAs($trade_log->portfolio->user);

        // Act:
        $response = $this->delete(sprintf('%s/%s', '/api/v1/trade-logs', $trade_log->id));

        // Assert:
        $this->assertSoftDeleted($trade_log);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);
    });

});
