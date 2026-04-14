<?php

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Application\TradeLog\UseCases\DeleteTradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

describe('Integration: DeleteTradeLog Use Case', function () {

    it('can hard delete trade log when using handle method.', function () {
        // Arrange:
        $trade_log = TradeLogModel::factory()->create();

        $dto = TradeLogDTO::fromModel($trade_log);

        $service = Mockery::mock(TradeLogService::class);

        $use_case = new DeleteTradeLog($service);

        // Expectation:
        $service->shouldReceive('delete')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
