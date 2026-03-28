<?php

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
            $count = 10;
            PortfolioModel::factory($count)->create();

            // Act:
            $result = $this->repository->fetchAll();

            // Assert:
            expect($result)
                ->toBeArray();

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
            $result = $this->repository->fetchAll();

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
