<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;

describe('Unit: Portfolio Service', function () {

    it('should return all portfolio when using fetchAll method.', function () {

        // Arrange:
        $portfolio = new Portfolio(
            user_id: random_int(1, 10),
            id: random_int(1, 10),
            name: 'PH Stock Market',
            created_at: now(),
            updated_at: null,
        );

        $repository = Mockery::mock(EloquentPortfolioReadRepository::class);

        // Assert (Expectation):
        $repository->shouldReceive('fetchAll')
            ->once()
            ->andReturn([
                $portfolio,
            ]);

        $service = new PortfolioService($repository);

        // Act:
        $service->fetchAll();
    });

});
