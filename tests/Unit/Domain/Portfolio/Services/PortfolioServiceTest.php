<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;

beforeEach(function () {
    $this->write_repository = Mockery::mock(PortfolioWriteRepositoryInterface::class);
    $this->read_repository = Mockery::mock(PortfolioReadRepositoryInterface::class);

    $this->service = new PortfolioService($this->write_repository, $this->read_repository);
});

describe('Unit: PortfolioService', function () {

    it('should return all portfolios when using findAll method.', function () {

        // Arrange:
        $portfolio = new Portfolio(
            user_id: rand(1, 10),
            name: 'PH Stock Market',
        );

        $criteria = new QueryCriteria;

        // Expectation:
        $this->read_repository->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $portfolio,
            ]);

        // Act:
        $result = $this->service->findAll($criteria);

        // Assert:
        expect($result)->toBeArray();
    });

    it('should return a portfolio when using findById method.', function () {

        // Arrange:
        $random_portfolio_id = rand(1, 10);

        $portfolio = new Portfolio(
            user_id: rand(1, 10),
            name: 'PH Stock Market',
            id: $random_portfolio_id,
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($random_portfolio_id)
            ->andReturn($portfolio);

        // Act:
        $result = $this->service->findById($random_portfolio_id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Portfolio::class)
            ->and($result->id())->toBe($random_portfolio_id);

    });

    it('should store portfolio when using store method.', function () {

        // Arrange:
        $portfolio = new Portfolio(
            user_id: rand(1, 10),
            name: 'PH Stock Market',
        );

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->with($portfolio)
            ->andReturn($portfolio);

        // Act:
        $result = $this->service->store($portfolio);

        // Assert
        expect($result)
            ->toBeInstanceOf(Portfolio::class)
            ->and($result->id())->toBe($portfolio->id());
    });

});
