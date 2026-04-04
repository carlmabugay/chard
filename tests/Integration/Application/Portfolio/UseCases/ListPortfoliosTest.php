<?php

use App\Application\Portolio\UseCases\ListPortfolios;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: ListPortfolios Use Case', function () {

    it('can list all portfolios when using handle method.', function () {
        // Arrange:
        $no_of_portfolios = 10;
        $portfolio_model = PortfolioModel::factory($no_of_portfolios)->create();
        $portfolio_entity = $portfolio_model->map(fn (PortfolioModel $model) => Portfolio::fromEloquentModel($model))->all();

        $service = Mockery::mock(PortfolioService::class);
        $criteria = Mockery::mock(QueryCriteria::class);

        $use_case = new ListPortfolios($service);

        $service->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $portfolio_entity,
            ]);

        // Act:
        $result = $use_case->handle($criteria);

        // Assert:
        expect($result)
            ->toBeArray()
            ->and(count($portfolio_entity))->toEqual($no_of_portfolios);
    });

});
