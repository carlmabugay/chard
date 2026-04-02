<?php

use App\Application\CashFlow\UserCases\ListCashFlows;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Domain\Common\Query\QueryCriteria;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: ListCashFlows Use Case', function () {

    it('should list all cash flows when using handle method.', function () {

        // Arrange:
        $no_of_cash_flows = 10;
        $cash_flow_model = CashFlowModel::factory($no_of_cash_flows)->create();
        $cash_flow_entity = $cash_flow_model->map(fn (CashFlowModel $model) => CashFlow::fromEloquentModel($model))->all();

        $service = Mockery::mock(CashFlowService::class);
        $criteria = Mockery::mock(QueryCriteria::class);

        $use_case = new ListCashFlows($service);

        $service->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $cash_flow_entity,
            ]);

        // Act:
        $result = $use_case->handle($criteria);

        // Assert:
        expect($result)
            ->toBeArray()
            ->and(count($cash_flow_entity))->toEqual($no_of_cash_flows);

    });
});
