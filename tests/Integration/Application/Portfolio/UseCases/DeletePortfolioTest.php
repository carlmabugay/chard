<?php

use App\Application\Portolio\UseCases\DeletePortfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: DeletePortfolio Use Case', function () {

    it('can hard delete portfolio when using handle method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $service = Mockery::mock(PortfolioService::class);

        $use_case = new DeletePortfolio($service);

        // Expectation:
        $service->shouldReceive('delete')
            ->once()
            ->with($portfolio->id)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($portfolio->id);

        // Assert:
        expect($result)->toBeTrue();
    });

});
