<?php

use App\Domain\CashFlow\Entities\CashFlow;
use App\Enums\CashFlowType;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentCashFlowWriteRepository;
use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;

beforeEach(function () {
    $this->repository = new EloquentCashFlowWriteRepository;
});

describe('Integration: EloquentCashFlowWriteRepository', function () {

    it('can create new cash flow when using store method.', function () {
        // Arrange
        $table = 'cash_flows';
        $portfolio = PortfolioModel::factory()->create();

        $cash_flow = new CashFlow(
            portfolio_id: $portfolio->id,
            type: CashFlowType::DEPOSIT,
            amount: 5000,
        );

        // Act:
        $result = $this->repository->store($cash_flow);

        // Assert:
        expect($result)->toBeInstanceOf(CashFlow::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'portfolio_id' => $cash_flow->portfolioId(),
            'type' => $cash_flow->type(),
            'amount' => $cash_flow->amount(),
        ]);

    });

    it('can update cash flow when using store method.', function () {
        // Arrange:
        $cash_flow_model = CashFlowModel::factory()->create();

        $cash_flow_entity = new CashFlow(
            portfolio_id: $cash_flow_model->portfolio->id,
            type: $cash_flow_model->type,
            amount: 5000,
            id: $cash_flow_model->id,
        );

        // Act:
        $result = $this->repository->store($cash_flow_entity);

        // Assert:
        expect($result)->toBeInstanceOf(CashFlow::class);

        $this->assertDatabaseHas('cash_flows', [
            'portfolio_id' => $cash_flow_entity->portfolioId(),
            'type' => $cash_flow_entity->type(),
            'amount' => $cash_flow_entity->amount(),
            'id' => $cash_flow_entity->id(),
        ]);
    });

    it('can soft delete cash flow when using trash method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        // Act:
        $this->repository->trash($cash_flow);

        // Assert:
        $this->assertSoftDeleted($cash_flow);
    });

    it('can restore trashed cash flow when using restore method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->trashed()->create();

        // Act:
        $this->repository->restore($cash_flow);

        // Assert:
        $this->assertNotSoftDeleted($cash_flow);
    });

    it('can hard delete cash flow when using delete method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        // Act:
        $this->repository->delete($cash_flow);

        // Assert:
        $this->assertModelMissing($cash_flow);
        $this->assertDatabaseMissing('cash_flows');
    });

});
