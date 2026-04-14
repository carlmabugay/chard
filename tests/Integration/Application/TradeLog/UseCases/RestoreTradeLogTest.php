<?php

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Application\TradeLog\UseCases\RestoreTradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

describe('Integration: RestoreTradeLog Use Case', function () {

    it('can restore trashed trade log when using handle method.', function () {
        // Arrange:
        $trade_log = TradeLogModel::factory()->trashed()->create();

        $dto = TradeLogDTO::fromModel($trade_log);

        $service = Mockery::mock(TradeLogService::class);

        $use_case = new RestoreTradeLog($service);

        // Expectation:
        $service->shouldReceive('restore')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
