<?php

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

    it('should return all portfolios when using fetchAll method.', function () {

        // Arrange:
        $portfolio = new Portfolio(
            user_id: random_int(1, 10),
            name: 'PH Stock Market',
        );

        // Expectation:
        $this->read_repository->shouldReceive('fetchAll')
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
            name: 'PH Stock Market',
            id: $id,
        );

        // Expectation:
        $this->read_repository->shouldReceive('fetchById')
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

    it('should store portfolio when using store method.', function () {

        // Arrange:
        $portfolio = new Portfolio(
            user_id: random_int(1, 10),
            name: 'PH Stock Market',
        );

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->with($portfolio)
            ->andReturn($portfolio);

        // Act:
        $stored_portfolio = $this->service->store($portfolio);

        // Assert
        expect($stored_portfolio)->toBeInstanceOf(Portfolio::class);
    });

});
