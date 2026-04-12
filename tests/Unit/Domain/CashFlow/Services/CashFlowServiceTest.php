<?php

use App\Domain\CashFlow\Contracts\Persistence\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Contracts\Persistence\Write\CashFlowWriteRepositoryInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Domain\Common\Query\QueryCriteria;
use App\Enums\CashFlowType;
use App\Models\CashFlow as CashFlowModel;

beforeEach(function () {
    $this->write_repository = Mockery::mock(CashFlowWriteRepositoryInterface::class);
    $this->read_repository = Mockery::mock(CashFlowReadRepositoryInterface::class);

    $this->service = new CashFlowService($this->write_repository, $this->read_repository);
});

describe('Unit: CashFlowService', function () {

    it('can return all cash flows when using findAll method.', function () {
        // Arrange:
        $cash_flow = new CashFlow(
            portfolio_id: rand(1, 10),
            type: CashFlowType::DEPOSIT,
            amount: 5000,
        );

        $criteria = new QueryCriteria;

        // Expectation:
        $this->read_repository->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $cash_flow,
            ]);

        // Act:
        $result = $this->service->findAll($criteria);

        // Assert:
        expect($result)->toBeArray();
    });

    it('can return a cash flow when using findById method.', function () {
        // Arrange:
        $cash_flow = new CashFlow(
            portfolio_id: rand(1, 10),
            type: CashFlowType::DEPOSIT,
            amount: 5000,
            id: rand(1, 10),
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($cash_flow->id())
            ->andReturn($cash_flow);

        // Act:
        $result = $this->service->findById($cash_flow->id());

        // Assert:
        expect($result)
            ->toBeInstanceOf(CashFlow::class)
            ->and($result->id())->toBe($cash_flow->id());
    });

    it('can store cash flow when using store method.', function () {
        // Arrange:
        $cash_flow = new CashFlow(
            portfolio_id: rand(1, 10),
            type: CashFlowType::DEPOSIT,
            amount: 5000,
        );

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->with($cash_flow)
            ->andReturn($cash_flow);

        // Act:
        $result = $this->service->store($cash_flow);

        // Assert:
        expect($result)
            ->toBeInstanceOf(CashFlow::class)
            ->and($result->id())->toBe($cash_flow->id());
    });

    it('can soft delete cash flow when using trash method.', function () {
        // Arrange:
        $cash_flow = Mockery::mock(CashFlowModel::class);

        // Expectation:
        $this->write_repository->shouldReceive('trash')
            ->once()
            ->with($cash_flow)
            ->andReturn(true);

        // Act:
        $result = $this->service->trash($cash_flow);

        // Assert:
        expect($result)->toBeTrue();
    });

    it('can restore trashed cash flow when using restore method.', function () {
        // Arrange:
        $cash_flow = Mockery::mock(CashFlowModel::class);

        // Expectation:
        $this->write_repository->shouldReceive('restore')
            ->once()
            ->with($cash_flow)
            ->andReturn(true);

        // Act:
        $result = $this->service->restore($cash_flow);

        // Assert:
        expect($result)->toBeTrue();
    });

    it('can hard delete cash flow when using delete method.', function () {
        // Arrange:
        $cash_flow = Mockery::mock(CashFlowModel::class);

        // Expectation:
        $this->write_repository->shouldReceive('delete')
            ->once()
            ->with($cash_flow)
            ->andReturn(true);

        // Act:
        $result = $this->service->delete($cash_flow);

        // Assert:
        expect($result)->toBeTrue();
    });

});
