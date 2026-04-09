<?php

use App\Application\TradeLog\UseCases\RestoreTradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

describe('Integration: RestoreTradeLog Use Case', function () {

    it('can restore trashed trade log when using handle method.', function () {
        // Arrange:
        $trade_log = TradeLogModel::factory()->trashed()->create();

        $service = Mockery::mock(TradeLogService::class);

        $use_case = new RestoreTradeLog($service);

        // Expectation:
        $service->shouldReceive('restore')
            ->once()
            ->with($trade_log)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($trade_log);

        // Assert:
        expect($result)->toBeTrue();
    });

});
