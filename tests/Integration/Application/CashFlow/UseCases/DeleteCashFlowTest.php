<?php

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Application\CashFlow\UserCases\DeleteCashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: DeleteCashFlow Use Case', function () {

    it('can hard delete cash flow when using handle method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        $dto = CashFlowDTO::fromModel($cash_flow);

        $service = Mockery::mock(CashFlowService::class);

        $use_case = new DeleteCashFlow($service);

        // Expectation:
        $service->shouldReceive('delete')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
