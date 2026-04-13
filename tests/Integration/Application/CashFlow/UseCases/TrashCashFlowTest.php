<?php

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Application\CashFlow\UserCases\TrashCashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: TrashCashFlow Use Case', function () {

    it('can soft delete cash flow when using handle method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        $dto = CashFlowDTO::fromModel($cash_flow);

        $service = Mockery::mock(CashFlowService::class);

        $use_case = new TrashCashFlow($service);

        // Expectation:
        $service->shouldReceive('trash')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
