<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->repository = new EloquentPortfolioReadRepository;
});

describe('Integration: EloquentPortfolioReadRepository', function () {

    describe('Positives', function () {

        it('should return all portfolio when using fetchAll method.', function () {

            // Arrange:
            $count = 10;
            PortfolioModel::factory(10)->create();

            // Act:
            $portfolios = $this->repository->fetchAll();

            // Assert:
            expect($portfolios)
                ->toBeArray()
                ->toHaveCount($count);

        });

        it('should return a portfolio when using fetchById method.', function () {

            // Arrange:
            $portfolio_model = PortfolioModel::factory()->create();

            // Act:
            $portfolio_entity = $this->repository->fetchById($portfolio_model->id);

            // Assert:
            expect($portfolio_entity)
                ->toBeInstanceOf(Portfolio::class)
                ->and($portfolio_entity->id())->toBe($portfolio_model->id);
        });
    });

    describe('Negatives', function () {

        it('should return an empty array when no records found upon using fetchAll method.', function () {

            // Act:
            $portfolios = $this->repository->fetchAll();

            // Assert:
            expect($portfolios)->toBeEmpty();

        });

        it('should throw an exception when no record found upon using fetchById method.', function () {

            // Act:
            $this->repository->fetchById(1);

            // Assert:
        })->throws(ModelNotFoundException::class);

    });

});
