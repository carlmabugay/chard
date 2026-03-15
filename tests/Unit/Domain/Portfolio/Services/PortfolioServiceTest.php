<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;

beforeEach(function () {
    $this->repository = Mockery::mock(EloquentPortfolioReadRepository::class);
    $this->service = new PortfolioService($this->repository);

});

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

        // Expectation:
        $this->repository->shouldReceive('fetchAll')
            ->once()
            ->andReturn([
                $portfolio,
            ]);

        // Act:
        $result = $this->service->fetchAll();

        // Assert:
        expect($result)->toBeArray();
    });

    it('should return a portfolio when using fetchById method.', function () {

        // Arrange:
        $id = random_int(1, 10);

        $portfolio = new Portfolio(
            user_id: random_int(1, 10),
            id: $id,
            name: 'PH Stock Market',
            created_at: now(),
            updated_at: null,
        );

        // Expectation:
        $this->repository->shouldReceive('fetchById')
            ->once()
            ->with($id)
            ->andReturn($portfolio);

        // Act:
        $result = $this->service->fetchById($id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Portfolio::class)
            ->and($result->id())->toBe($id);

    });

});
