<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Common\Query\Sort;
use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentDividendReadRepository;
use App\Models\Dividend as DividendModel;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentDividendReadRepository;
});

describe('Integration: EloquentDividendReadRepository', function () {

    describe('Positives', function () {

        it('should return all dividends when using findAll method.', function () {

            // Arrange:
            $no_of_dividends = 10;
            $portfolio = PortfolioModel::factory()->create();
            DividendModel::factory()
                ->count($no_of_dividends)
                ->create([
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
            DividendModel::factory($count)->create();

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

        it('should sort by amount ascending when using findAll method.', function () {

            // Arrange:
            DividendModel::factory()->create(['amount' => 4000]);
            DividendModel::factory()->create(['amount' => 2500]);
            DividendModel::factory()->create(['amount' => 10200]);

            $criteria = new QueryCriteria(
                sorts: [
                    new Sort('amount', 'desc'),
                ]
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            $amounts = collect($result['data'])->map(fn ($item) => $item->amount())->all();

            // Assert
            expect($amounts)->toBe([10200.00, 4000.00, 2500.00]);

        });

        it('should search by symbol when using findAll method.', function () {

            // Arrange:
            $symbol_to_search = 'BPI';
            DividendModel::factory()->create(['symbol' => 'JFC']);
            DividendModel::factory()->create(['symbol' => 'AC']);
            DividendModel::factory()->create(['symbol' => $symbol_to_search]);

            $criteria = new QueryCriteria(
                search: $symbol_to_search
            );

            // Act
            $result = $this->repository->findAll($criteria);

            // Assert
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->symbol())
                ->toContain($symbol_to_search);

        });

        it('should apply sort and pagination together when using findAll method.', function () {

            // Arrange:
            DividendModel::factory()->create(['amount' => 4000]);
            DividendModel::factory()->create(['amount' => 2500]);
            DividendModel::factory()->create(['amount' => 10200]);

            $criteria = new QueryCriteria(
                page: 1,
                per_page: 1,
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
                ->toBe(10200.00);

        });

        it('should return a cash flows when using findById method.', function () {

            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $result = $this->repository->findById($dividend->id);

            // Assert:
            expect($result)
                ->toBeInstanceOf(Dividend::class)
                ->and($result->id())->toBe($dividend->id);

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
