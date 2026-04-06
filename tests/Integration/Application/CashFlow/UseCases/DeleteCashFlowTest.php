<?php

use App\Application\CashFlow\UserCases\DeleteCashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: DeleteCashFlow Use Case', function () {

    it('can hard delete cash flow when using handle method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        $service = Mockery::mock(CashFlowService::class);

        $use_case = new DeleteCashFlow($service);

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
