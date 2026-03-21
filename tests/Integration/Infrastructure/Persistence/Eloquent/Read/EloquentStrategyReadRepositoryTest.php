<?php

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
            $count = 10;
            StrategyModel::factory($count)->create();

            // Act:
            $result = $this->repository->fetchAll();

            // Assert:
            expect($result)
                ->toBeArray()
                ->toHaveCount($count);

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
            $result = $this->repository->fetchAll();

            // Assert:
            expect($result)->toBeEmpty();

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
