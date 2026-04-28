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

        it('can return a portfolio when using findById method.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            // Act:
            $result = $this->repository->findById($portfolio->id);

            // Assert:
            expect($result)
                ->toBeInstanceOf(Portfolio::class)
                ->and($result->id())->toBe($portfolio->id);
        });
    });

    describe('Negatives', function () {

        it('can throw an exception when no record found upon using findById method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->findById($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

    });

});
