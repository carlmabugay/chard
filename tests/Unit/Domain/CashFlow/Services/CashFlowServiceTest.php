<?php

use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentCashFlowReadRepository;

beforeEach(function () {
    $this->read_repository = Mockery::mock(EloquentCashFlowReadRepository::class);
    $this->service = new CashFlowService($this->read_repository);
});

describe('Unit: Cash Flow Service', function () {

    it('should return all cash flows when using findAll method.', function () {

        // Arrange:
        $cash_flow = new CashFlow(
            portfolio_id: random_int(1, 10),
            type: 'deposit',
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
});
