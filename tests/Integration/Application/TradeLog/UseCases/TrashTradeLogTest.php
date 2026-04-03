<?php

use App\Application\TradeLog\UseCases\TrashTradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

describe('Integration: TrashTradeLog Use Case', function () {

    it('should soft delete trade log when using handle method.', function () {

        // Arrange:
        $trade_log = TradeLogModel::factory()->create();

        $service = Mockery::mock(TradeLogService::class);

        // Expectation:
        $service->shouldReceive('trash')
            ->once()
            ->with($trade_log->id)
            ->andReturn(true);

        // Act:
        $use_case = new TrashTradeLog($service);
        $result = $use_case->handle($trade_log->id);

        // Assert:
        expect($result)->toBeTrue();
    });

});
