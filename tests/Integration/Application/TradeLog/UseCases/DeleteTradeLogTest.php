<?php

use App\Application\TradeLog\UseCases\DeleteTradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

describe('Integration: DeleteTradeLog Use Case', function () {

    it('can hard delete trade log when using handle method.', function () {
        // Arrange:
        $cash_flow = TradeLogModel::factory()->create();

        $service = Mockery::mock(TradeLogService::class);

        $use_case = new DeleteTradeLog($service);

        // Expectation:
        $service->shouldReceive('delete')
            ->once()
            ->with($cash_flow->id)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($cash_flow->id);

        // Assert:
        expect($result)->toBeTrue();
    });

});
