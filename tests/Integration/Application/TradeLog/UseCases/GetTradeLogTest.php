<?php

use App\Application\TradeLog\UseCases\GetTradeLog;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

describe('Integration: GetTradeLog Use Case', function () {

    it('can return trade log that filtered by id when using handle method.', function () {
        // Arrange:
        $trade_log_model = TradeLogModel::factory()->create();

        $trade_log_entity = TradeLog::fromEloquentModel($trade_log_model);

        $service = Mockery::mock(TradeLogService::class);

        $use_case = new GetTradeLog($service);

        // Expectation:
        $service->shouldReceive('findById')
            ->once()
            ->with($trade_log_model->id)
            ->andReturn($trade_log_entity);

        // Act:
        $result = $use_case->handle($trade_log_model->id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(TradeLog::class)
            ->and($result->id())->toBe($trade_log_entity->id());
    });

});
