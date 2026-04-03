<?php

use App\Application\CashFlow\UserCases\TrashCashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: TrashCashFlow Use Case', function () {

    it('should soft delete cash flow when using handle method.', function () {

        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        $service = Mockery::mock(CashFlowService::class);

        // Expectation:
        $service->shouldReceive('trash')
            ->once()
            ->with($cash_flow->id)
            ->andReturn(true);

        // Act:
        $use_case = new TrashCashFlow($service);
        $result = $use_case->handle($cash_flow->id);

        // Assert:
        expect($result)->toBeTrue();
    });

});
