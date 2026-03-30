<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Common\Query\Sort;
use App\Domain\Strategy\Entities\Strategy;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentStrategyReadRepository;
use App\Models\Strategy as StrategyModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentStrategyReadRepository;
});

describe('Integration: EloquentStrategyReadRepository', function () {

    describe('Positives', function () {

        it('should return all strategies when using fetchAll method.', function () {

            // Arrange:
            $no_of_strategies = 10;
            StrategyModel::factory($no_of_strategies)->create();

            // Act:
            $result = $this->repository->fetchAll(new QueryCriteria);

            // Assert:
            expect($result)
                ->toBeArray()
                ->and(expect($result['data'])->toHaveCount($no_of_strategies));

        });

        it('should paginate correctly when using fetchAll method.', function () {

            // Arrange:
            $count = 50;
            StrategyModel::factory($count)->create();

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

            StrategyModel::factory()->create(['created_at' => $created_now]);
            StrategyModel::factory()->create(['created_at' => $created_ten_days_ago]);
            StrategyModel::factory()->create(['created_at' => $create_twenty_days_ago]);

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
            $name_to_search = 'Trend Following';
            StrategyModel::factory()->create(['name' => 'Pullback']);
            StrategyModel::factory()->create(['name' => $name_to_search]);

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

        it('should apply sort and pagination together when using fetchAll method.', function () {

            // Arrange:
            $created_now = now();
            $created_ten_days_ago = $created_now->subDays(10);
            $create_twenty_days_ago = $created_now->subDays(20);

            StrategyModel::factory()->create(['created_at' => $created_now]);
            StrategyModel::factory()->create(['created_at' => $created_ten_days_ago]);
            StrategyModel::factory()->create(['created_at' => $create_twenty_days_ago]);

            $criteria = new QueryCriteria(
                page: 1,
                per_page: 1,
                sorts: [
                    new Sort('created_at', 'asc'),
                ]
            );

            // Act:
            $result = $this->repository->fetchAll($criteria);

            // Assert:
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->createdAt())
                ->toBe($create_twenty_days_ago->toDateTimeString());

        });

        it('should return a strategy when using fetchById method.', function () {

            // Arrange:
            $strategy = StrategyModel::factory()->create();

            // Act:
            $result = $this->repository->fetchById($strategy->id);

            // Assert:
            expect($result)
                ->toBeInstanceOf(Strategy::class)
                ->and($result->id())->toBe($strategy->id);
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
