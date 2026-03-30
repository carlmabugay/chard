<?php

use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\Common\Query\Filter;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Common\Query\Sort;
use App\Enums\CashFlowType;
use App\Enums\OperatorType;
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

        it('should paginate correctly when using findAll method.', function () {

            // Arrange:
            $count = 50;
            CashFlowModel::factory($count)->create();

            $page_number = 2;
            $per_page = 10;

            $criteria = new QueryCriteria(
                page: $page_number,
                per_page: $per_page,
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            // Assert:
            expect($result)
                ->toBeArray()
                ->and(expect($result['pagination']['current_page'])->toBe($page_number))
                ->and(count($result['data']))->toBe($per_page);

        });

        it('should filter by type when using findAll method.', function () {

            // Arrange:
            CashFlowModel::factory()->create(['type' => CashFlowType::DEPOSIT]);
            CashFlowModel::factory()->create(['type' => CashFlowType::WITHDRAW]);

            $criteria = new QueryCriteria(
                filters: [
                    new Filter('type', OperatorType::EQ->value, CashFlowType::DEPOSIT->value),
                ]
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            // Assert:
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->type())
                ->toBe(CashFlowType::DEPOSIT);

        });

        it('should sort by amount descending when using findAll method.', function () {

            // Arrange:
            CashFlowModel::factory()->create(['amount' => 300]);
            CashFlowModel::factory()->create(['amount' => 100]);
            CashFlowModel::factory()->create(['amount' => 200]);

            $criteria = new QueryCriteria(
                sorts: [
                    new Sort('amount', 'desc'),
                ]
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            $amounts = collect($result['data'])->map(fn ($item) => $item->amount())->all();

            // Assert
            expect($amounts)->toBe([300.00, 200.00, 100.00]);

        });

        it('should search by amount when using findAll method.', function () {

            // Arrange:
            $amount_to_search = 3000.00;
            CashFlowModel::factory()->create(['amount' => 5000]);
            CashFlowModel::factory()->create(['amount' => 15000]);
            CashFlowModel::factory()->create(['amount' => $amount_to_search]);

            $criteria = new QueryCriteria(
                search: $amount_to_search
            );

            // Act
            $result = $this->repository->findAll($criteria);

            // Assert
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->amount())
                ->toBe($amount_to_search);

        });

        it('should apply filter, sort, and pagination together when using findAll method.', function () {

            // Arrange:
            CashFlowModel::factory()->create(['type' => CashFlowType::DEPOSIT, 'amount' => 200]);
            CashFlowModel::factory()->create(['type' => CashFlowType::WITHDRAW, 'amount' => 100]);
            CashFlowModel::factory()->create(['type' => CashFlowType::DEPOSIT, 'amount' => 300]);

            $criteria = new QueryCriteria(
                page: 1,
                per_page: 1,
                filters: [
                    new Filter('type', OperatorType::EQ->value, CashFlowType::DEPOSIT->value),
                ],
                sorts: [
                    new Sort('amount', 'desc'),
                ]
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            // Assert
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->amount())
                ->toBe(300.00);

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
