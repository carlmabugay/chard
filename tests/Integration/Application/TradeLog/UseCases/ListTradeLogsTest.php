<?php

use App\Application\TradeLog\UseCases\ListTradeLogs;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

describe('Integration: ListTradeLogs Use Case', function () {

    it('should list all trade logs when using handle method.', function () {

        // Arrange:
        $no_of_trade_logs = 10;
        $trade_log_model = TradeLogModel::factory($no_of_trade_logs)->create();
        $trade_log_entity = $trade_log_model->map(fn (TradeLogModel $model) => TradeLog::fromEloquentModel($model))->all();

        $service = Mockery::mock(TradeLogService::class);
        $criteria = Mockery::mock(QueryCriteria::class);

        $use_case = new ListTradeLogs($service);

        $service->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $trade_log_entity,
            ]);

        // Act:
        $result = $use_case->handle($criteria);

        // Assert:
        expect($result)
            ->toBeArray()
            ->and(count($trade_log_entity))->toEqual($no_of_trade_logs);

    });
});
