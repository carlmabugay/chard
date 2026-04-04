<?php

use App\Application\Portolio\UseCases\TrashPortfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: TrashPortfolio Use Case', function () {

    it('can soft delete portfolio when using handle method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $service = Mockery::mock(PortfolioService::class);

        $use_case = new TrashPortfolio($service);

        // Expectation:
        $service->shouldReceive('trash')
            ->once()
            ->with($portfolio->id)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($portfolio->id);

        // Assert:
        expect($result)->toBeTrue();
    });

});
