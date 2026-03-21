<?php

use App\Domain\CashFlow\Contracts\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Contracts\Write\CashFlowWriteRepositoryInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Enums\CashFlowType;

beforeEach(function () {
    $this->write_repository = Mockery::mock(CashFlowWriteRepositoryInterface::class);
    $this->read_repository = Mockery::mock(CashFlowReadRepositoryInterface::class);

    $this->service = new CashFlowService($this->write_repository, $this->read_repository);
});

describe('Unit: CashFlowService', function () {

    it('should return all cash flows when using findAll method.', function () {

        // Arrange:
        $cash_flow = new CashFlow(
            portfolio_id: rand(1, 10),
            type: CashFlowType::DEPOSIT,
            amount: 5000,
        );

        // Expectation:
        $this->read_repository->shouldReceive('findAll')
            ->once()
            ->andReturn([
                $cash_flow,
            ]);

        // Act:
        $result = $this->service->findAll();

        // Assert:
        expect($result)->toBeArray();
    });

    it('should return a cash flows when using findById method.', function () {

        // Arrange:
        $random_cash_flow_id = rand(1, 10);
        $cash_flow = new CashFlow(
            portfolio_id: rand(1, 10),
            type: CashFlowType::DEPOSIT,
            amount: 5000,
            id: $random_cash_flow_id,
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($random_cash_flow_id)
            ->andReturn($cash_flow);

        // Act:
        $result = $this->service->findById($random_cash_flow_id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(CashFlow::class)
            ->and($result->id())->toBe($random_cash_flow_id);

    });

    it('should store cash flow when using store method.', function () {

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
});
