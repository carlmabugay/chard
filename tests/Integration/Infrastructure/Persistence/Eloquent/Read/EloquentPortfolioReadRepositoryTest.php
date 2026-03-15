<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: EloquentPortfolioReadRepository', function () {

    it('should return all portfolio when using fetchAll method.', function () {

        // Arrange:
        $count = 10;
        PortfolioModel::factory(10)->create();

        $repository = new EloquentPortfolioReadRepository;

        // Act:
        $portfolios = $repository->fetchAll();

        // Assert:
        expect($portfolios)->toHaveCount($count);

    });

    it('should return a portfolio when using fetchById method.', function () {

        // Arrange:
        $portfolio_model = PortfolioModel::factory()->create();

        $repository = new EloquentPortfolioReadRepository;

        // Act:
        $portfolio_entity = $repository->fetchById($portfolio_model->id);

        // Assert:
        expect($portfolio_entity)
            ->toBeInstanceOf(Portfolio::class)
            ->and($portfolio_entity->id())->toBe($portfolio_model->id);
    });
});
