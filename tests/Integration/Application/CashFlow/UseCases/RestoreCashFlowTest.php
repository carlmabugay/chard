<?php

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Application\CashFlow\UserCases\RestoreCashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: RestoreCashFlow Use Case', function () {

    it('can restore trashed cash flow when using handle method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->trashed()->create();

        $dto = CashFlowDTO::fromModel($cash_flow);

        $service = Mockery::mock(CashFlowService::class);

        $use_case = new RestoreCashFlow($service);

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
