<?php

use App\Application\CashFlow\UserCases\ListCashFlows;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\CashFlow as CashFlowModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: List of all Cash Flows', function () {

    it('should list all cash flows when using handle method.', function () {

        // Arrange:
        $count = 10;
        $cash_flow_model = CashFlowModel::factory()->count($count)->create();
        $cash_flow_entity = $cash_flow_model->map(
            fn (CashFlowModel $model) => CashFlow::fromEloquentModel($model)
        )->all();

        $service = Mockery::mock(CashFlowService::class);

        $use_case = new ListCashFlows($service);

        $service->shouldReceive('findAll')
            ->once()
            ->andReturn([
                $cash_flow_entity,
            ]);

        // Act:
        $result = $use_case->handle();

        // Assert:
        expect($result)->toBeArray()
            ->and(count($cash_flow_entity))->toEqual($count);

    });
});
