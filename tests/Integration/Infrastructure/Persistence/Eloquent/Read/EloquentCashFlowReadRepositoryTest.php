<?php

use App\Domain\CashFlow\Entities\CashFlow;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentCashFlowReadRepository;
use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->repository = new EloquentCashFlowReadRepository;
});

describe('Integration: EloquentCashFlowReadRepository', function () {

    it('should return all cash flows when using findAll method.', function () {

        // Arrange:
        $count = 10;
        $portfolio = PortfolioModel::factory()->create();
        CashFlowModel::factory($count)->create([
            'portfolio_id' => $portfolio->id,
        ]);

        // Act:
        $result = $this->repository->findAll();

        // Assert:
        expect($result)
            ->toBeArray()
            ->toHaveCount($count);

    });

    it('should return a portfolio when using findById method.', function () {

        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        // Act:
        $result = $this->repository->findById($cash_flow->id);

        // Assert:
        expect($result)->toBeInstanceOf(CashFlow::class)
            ->and($result->id())->toBe($cash_flow->id);

    });

});
