<?php

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Models\CashFlow as CashFlowModel;

describe('Integration: GetCashFlow Use Case', function () {

    it('can return cash flow that filtered by id when using handle method.', function () {
        // Arrange:
        $cash_flow_model = CashFlowModel::factory()->create();

        $cash_flow_entity = CashFlow::fromEloquentModel($cash_flow_model);

        $use_case = new GetCashFlow;

        // Act:
        $result = $use_case->handle($cash_flow_model);

        // Assert:
        expect($result)
            ->toBeInstanceOf(CashFlow::class)
            ->and($result->id())->toBe($cash_flow_entity->id());
    });

});
