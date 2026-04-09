<?php

use App\Application\CashFlow\UserCases\RestoreCashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: RestoreCashFlow Use Case', function () {

    it('can restore trashed cash flow when using handle method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->trashed()->create();

        $service = Mockery::mock(CashFlowService::class);

        $use_case = new RestoreCashFlow($service);

        // Expectation:
        $service->shouldReceive('restore')
            ->once()
            ->with($cash_flow)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($cash_flow);

        // Assert:
        expect($result)->toBeTrue();
    });

});
