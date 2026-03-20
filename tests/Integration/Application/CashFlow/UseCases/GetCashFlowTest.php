<?php

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: GetCashFlow Use Case', function () {

    it('should return cash flow that filtered by id when using handle method.', function () {

        // Arrange:
        $cash_flow_model = CashFlowModel::factory()->create();

        $cash_flow_entity = new CashFlow(
            portfolio_id: $cash_flow_model->portfolio_id,
            type: $cash_flow_model->type,
            amount: $cash_flow_model->amount,
            id: $cash_flow_model->id,
            created_at: $cash_flow_model->created_at,
            updated_at: $cash_flow_model->updated_at,
        );

        $service = Mockery::mock(CashFlowService::class);

        $use_case = new GetCashFlow($service);

        // Expectation:
        $service->shouldReceive('findById')
            ->once()
            ->with($cash_flow_model->id)
            ->andReturn($cash_flow_entity);

        // Act:
        $result = $use_case->handle($cash_flow_model->id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(CashFlow::class)
            ->and($result->id())->toBe($cash_flow_model->id);

    });
});
