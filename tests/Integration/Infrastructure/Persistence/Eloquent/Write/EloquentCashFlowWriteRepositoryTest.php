<?php

use App\Domain\CashFlow\Entities\CashFlow;
use App\Enums\CashFlowType;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentCashFlowWriteRepository;
use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: EloquentCashFlowWriteRepository', function () {

    it('should create new cash flow when using store method.', function () {

        // Arrange
        $table = 'cash_flows';
        $portfolio = PortfolioModel::factory()->create();

        $cash_flow_entity = new CashFlow(
            type: CashFlowType::DEPOSIT,
            amount: 5000,
            portfolio_id: $portfolio->id,
        );

        // Act:
        $repository = new EloquentCashFlowWriteRepository;

        $result = $repository->store($cash_flow_entity);

        // Assert:
        expect($result)->toBeInstanceOf(CashFlow::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'portfolio_id' => $result->portfolioId(),
            'type' => $result->type(),
            'amount' => $result->amount(),
            'id' => $result->id(),
        ]);

    });

    it('should update cash flow when using store method.', function () {

        // Arrange:
        $cash_flow_model = CashFlowModel::factory()->create();

        $cash_flow_entity = new CashFlow(
            type: $cash_flow_model->type,
            amount: 5000,
            id: $cash_flow_model->id,
            portfolio_id: $cash_flow_model->portfolio->id,
        );

        // Act:
        $repository = new EloquentCashFlowWriteRepository;

        $result = $repository->store($cash_flow_entity);

        // Assert:
        expect($result)->toBeInstanceOf(CashFlow::class);

        $this->assertDatabaseHas('cash_flows', [
            'portfolio_id' => $result->portfolioId(),
            'type' => $result->type(),
            'amount' => $result->amount(),
            'id' => $result->id(),
        ]);
    });

});
