<?php

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Application\Portolio\UseCases\RestorePortfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: RestorePortfolio Use Case', function () {

    it('can restore trashed portfolio when using handle method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()->trashed()->create();

        $dto = PortfolioDTO::fromModel($portfolio);

        $service = Mockery::mock(PortfolioService::class);

        $use_case = new RestorePortfolio($service);

        // Expectation:
        $service->shouldReceive('restore')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
