<?php

use App\Application\Portolio\UseCases\GetPortfolio;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: GetPortfolio Use Case', function () {

    it('should return portfolio that filtered by id when using handle method.', function () {

        // Arrange:
        $portfolio_model = PortfolioModel::factory()->create();

        $portfolio_entity = new Portfolio(
            user_id: $portfolio_model->user_id,
            name: $portfolio_model->name,
            id: $portfolio_model->id,
            created_at: $portfolio_model->created_at,
            updated_at: $portfolio_model->updated_at,
        );

        $service = Mockery::mock(PortfolioService::class);

        $use_case = new GetPortfolio($service);

        // Expectation:
        $service->shouldReceive('fetchById')
            ->once()
            ->with($portfolio_model->id)
            ->andReturn($portfolio_entity);

        // Act:
        $result = $use_case->handle($portfolio_model->id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Portfolio::class)
            ->and($result->name())->toBe($portfolio_entity->name());

    });
});
