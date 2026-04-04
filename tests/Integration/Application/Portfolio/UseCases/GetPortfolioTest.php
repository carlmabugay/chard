<?php

use App\Application\Portolio\UseCases\GetPortfolio;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: GetPortfolio Use Case', function () {

    it('can return portfolio that filtered by id when using handle method.', function () {
        // Arrange:
        $portfolio_model = PortfolioModel::factory()->create();

        $portfolio_entity = Portfolio::fromEloquentModel($portfolio_model);

        $service = Mockery::mock(PortfolioService::class);

        $use_case = new GetPortfolio($service);

        // Expectation:
        $service->shouldReceive('findById')
            ->once()
            ->with($portfolio_model->id)
            ->andReturn($portfolio_entity);

        // Act:
        $result = $use_case->handle($portfolio_model->id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Portfolio::class)
            ->and(($result->id()))->toBe($portfolio_entity->id())
            ->and($result->name())->toBe($portfolio_entity->name());
    });

});
