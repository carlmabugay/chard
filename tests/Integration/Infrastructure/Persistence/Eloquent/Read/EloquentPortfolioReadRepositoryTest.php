<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Common\Query\Sort;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentPortfolioReadRepository;
});

describe('Integration: EloquentPortfolioReadRepository', function () {

    describe('Positives', function () {

        it('should return all portfolios when using fetchAll method.', function () {

            // Arrange:
            $no_of_portfolios = 10;
            PortfolioModel::factory($no_of_portfolios)->create();

            // Act:
            $result = $this->repository->fetchAll(new QueryCriteria);

            // Assert:
            expect($result)
                ->toBeArray()
                ->and(expect($result['data'])->toHaveCount($no_of_portfolios));

        });

        it('should paginate correctly when using fetchAll method.', function () {

            // Arrange:
            $no_of_portfolios = 50;
            PortfolioModel::factory($no_of_portfolios)->create();

            $page_number = 2;
            $per_page = 10;

            $criteria = new QueryCriteria(
                page: $page_number,
                per_page: $per_page,
            );

            // Act:
            $result = $this->repository->fetchAll($criteria);

            // Assert:
            expect($result)
                ->toBeArray()
                ->and(expect($result['pagination']['current_page'])->toBe($page_number))
                ->and(count($result['data']))->toBe($per_page);

        });

        it('should sort by created date ascending when using fetchAll method.', function () {

            // Arrange:
            $created_now = now();
            $created_ten_days_ago = now()->subDays(10);
            $create_twenty_days_ago = now()->subDays(20);

            PortfolioModel::factory()->create(['created_at' => $created_now]);
            PortfolioModel::factory()->create(['created_at' => $created_ten_days_ago]);
            PortfolioModel::factory()->create(['created_at' => $create_twenty_days_ago]);

            $criteria = new QueryCriteria(
                sorts: [
                    new Sort('created_at', 'asc'),
                ]
            );

            // Act:
            $result = $this->repository->fetchAll($criteria);

            $dates = collect($result['data'])->map(fn ($item) => $item->createdAt())->all();

            // Assert
            expect($dates)->toBe([
                $create_twenty_days_ago->toDateTimeString(),
                $created_ten_days_ago->toDateTimeString(),
                $created_now->toDateTimeString(),
            ]);
        });

        it('should search by name when using fetchAll method.', function () {

            // Arrange:
            $name_to_search = 'Forex';
            PortfolioModel::factory()->create(['name' => 'Philippine Stock Market']);
            PortfolioModel::factory()->create(['name' => $name_to_search]);

            $criteria = new QueryCriteria(
                search: $name_to_search
            );

            // Act
            $result = $this->repository->fetchAll($criteria);

            // Assert
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->name())
                ->toContain($name_to_search);

        });

        it('should apply search, sort and pagination together when using fetchAll method.', function () {

            // Arrange:
            $created_now = now();
            $created_ten_days_ago = $created_now->subDays(10);
            $create_twenty_days_ago = $created_now->subDays(20);

            $name_to_search = 'Forex';

            PortfolioModel::factory()->create(['name' => 'Philippine Stock Market', 'created_at' => $created_now]);
            PortfolioModel::factory()->create(['name' => 'Crypto - Alt coins', 'created_at' => $created_ten_days_ago]);
            PortfolioModel::factory()->create(['name' => $name_to_search, 'created_at' => $create_twenty_days_ago]);

            $criteria = new QueryCriteria(
                page: 1,
                per_page: 1,
                search: $name_to_search,
                sorts: [
                    new Sort('created_at', 'asc'),
                ]
            );

            // Act:
            $result = $this->repository->fetchAll($criteria);

            // Assert:
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->name())
                ->toContain($name_to_search)
                ->and($result['data'][0]->createdAt())
                ->toBe($create_twenty_days_ago->toDateTimeString());

        });

        it('should return a portfolio when using fetchById method.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            // Act:
            $result = $this->repository->fetchById($portfolio->id);

            // Assert:
            expect($result)
                ->toBeInstanceOf(Portfolio::class)
                ->and($result->id())->toBe($portfolio->id);
        });
    });

    describe('Negatives', function () {

        it('should return an empty array when no records found upon using fetchAll method.', function () {

            // Act:
            $result = $this->repository->fetchAll(new QueryCriteria);

            // Assert:
            expect($result['data'])->toBeEmpty();

        });

        it('should throw an exception when no record found upon using fetchById method.', function () {

            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->fetchById($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

    });

});
