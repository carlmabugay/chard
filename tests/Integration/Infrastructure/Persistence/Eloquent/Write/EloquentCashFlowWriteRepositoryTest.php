<?php

use App\Application\CashFlow\DTOs\CashFlowDTO;
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

        $dto = new CashFlowDTO(
            portfolio_id: $portfolio->id,
            type: CashFlowType::DEPOSIT,
            amount: 5000,
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(CashFlow::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'portfolio_id' => $dto->portfolioId(),
            'type' => $dto->type(),
            'amount' => $dto->amount(),
        ]);

    });

    it('can update cash flow when using store method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        $dto = new CashFlowDTO(
            portfolio_id: $cash_flow->portfolio->id,
            type: $cash_flow->type,
            amount: 5000,
            id: $cash_flow->id,
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(CashFlow::class);

        $this->assertDatabaseHas('cash_flows', [
            'portfolio_id' => $dto->portfolioId(),
            'type' => $dto->type(),
            'amount' => $dto->amount(),
            'id' => $dto->id(),
        ]);
    });

    it('can soft delete cash flow when using trash method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        $dto = CashFlowDTO::fromModel($cash_flow);

        // Act:
        $this->repository->trash($dto);

        // Assert:
        $this->assertSoftDeleted($cash_flow);
    });

    it('can restore trashed cash flow when using restore method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->trashed()->create();

        $dto = CashFlowDTO::fromModel($cash_flow);

        // Act:
        $this->repository->restore($dto);

        // Assert:
        $this->assertNotSoftDeleted($cash_flow);
    });

    it('can hard delete cash flow when using delete method.', function () {
        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        $dto = CashFlowDTO::fromModel($cash_flow);

        // Act:
        $this->repository->delete($dto);

        // Assert:
        $this->assertModelMissing($cash_flow);
        $this->assertDatabaseMissing('cash_flows');
    });

});
