<?php

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
        $cash_flows = $this->repository->findAll();

        // Assert:
        expect($cash_flows)
            ->toBeArray()
            ->toHaveCount($count);

    });

});
