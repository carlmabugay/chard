<?php

use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\Common\Query\QueryCriteria;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentCashFlowReadRepository;
use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentCashFlowReadRepository;
});

describe('Integration: EloquentCashFlowReadRepository', function () {

    describe('Positives', function () {

        it('should return all cash flows when using findAll method.', function () {

            // Arrange:
            $count = 10;
            $portfolio = PortfolioModel::factory()->create();
            CashFlowModel::factory($count)->create([
                'portfolio_id' => $portfolio->id,
            ]);

            // Act:
            $result = $this->repository->findAll(new QueryCriteria);

            // Assert:
            expect($result)
                ->toBeArray();

        });

        it('should return a cash flows when using findById method.', function () {

            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $result = $this->repository->findById($cash_flow->id);

            // Assert:
            expect($result)
                ->toBeInstanceOf(CashFlow::class)
                ->and($result->id())->toBe($cash_flow->id);

        });

    });

    describe('Negatives', function () {

        it('should return an empty array when no records found upon using findAll method.', function () {

            // Act:
            $result = $this->repository->findAll(new QueryCriteria);

            // Assert:
            expect($result['data'])->toBeEmpty();

        });

        it('should throw an exception when no record found upon using findById method.', function () {

            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->findById($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

    });

});
