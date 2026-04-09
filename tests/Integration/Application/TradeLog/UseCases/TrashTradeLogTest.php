<?php

use App\Application\TradeLog\UseCases\TrashTradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

describe('Integration: TrashTradeLog Use Case', function () {

    it('can soft delete trade log when using handle method.', function () {
        // Arrange:
        $trade_log = TradeLogModel::factory()->create();

        $service = Mockery::mock(TradeLogService::class);

        $use_case = new TrashTradeLog($service);

        // Expectation:
        $service->shouldReceive('trash')
            ->once()
            ->with($trade_log)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($trade_log);

        // Assert:
        expect($result)->toBeTrue();
    });

});
