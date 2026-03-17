<?php

use App\Application\UseCases\ListPortfolios;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: List of all Portfolios', function () {

    it('should list all portfolios when using handle method.', function () {

        // Arrange:
        $count = 10;
        $portfolio_model = PortfolioModel::factory()->count($count)->create();
        $portfolio_entity = $portfolio_model->map(
            fn (PortfolioModel $model) => Portfolio::fromEloquentModel($model)
        )->all();

        $service = Mockery::mock(PortfolioService::class);

        $use_case = new ListPortfolios($service);

        $service->shouldReceive('fetchAll')
            ->once()
            ->andReturn([
                $portfolio_entity,
            ]);

        // Act:
        $result = $use_case->handle();

        // Assert:
        expect($result)->toBeArray()
            ->and(count($portfolio_entity))->toEqual($count);

    });
});
