<?php

use App\Domain\CashFlow\Entities\CashFlow;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentCashFlowWriteRepository;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: EloquentCashFlowWriteRepository', function () {

    it('should create new cash flow when using store method.', function () {

        // Arrange
        $table = 'cash_flows';
        $portfolio = PortfolioModel::factory()->create();

        $cash_flow_entity = new CashFlow(
            portfolio_id: $portfolio->id,
            type: 'deposit',
            amount: 5000,
        );

        // Act:
        $repository = new EloquentCashFlowWriteRepository;

        $stored_cash_flow = $repository->store($cash_flow_entity);

        // Assert:
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'portfolio_id' => $portfolio->id,
            'type' => 'deposit',
            'amount' => 5000,
        ]);

        expect($stored_cash_flow)->toBeInstanceOf(CashFlow::class);

    });

});
