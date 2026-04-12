<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Contracts\Persistence\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Persistence\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;

beforeEach(function () {
    $this->write_repository = Mockery::mock(PortfolioWriteRepositoryInterface::class);
    $this->read_repository = Mockery::mock(PortfolioReadRepositoryInterface::class);

    $this->service = new PortfolioService($this->write_repository, $this->read_repository);
});

describe('Unit: PortfolioService', function () {

    it('can return all portfolios when using findAll method.', function () {
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

    it('can return a portfolio when using findById method.', function () {
        // Arrange:
        $portfolio = new Portfolio(
            user_id: rand(1, 10),
            name: 'PH Stock Market',
            id: rand(1, 10),
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($portfolio->id())
            ->andReturn($portfolio);

        // Act:
        $result = $this->service->findById($portfolio->id());

        // Assert:
        expect($result)
            ->toBeInstanceOf(Portfolio::class)
            ->and($result->id())->toBe($portfolio->id());
    });

    it('can store portfolio when using store method.', function () {
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

    it('can soft delete portfolio when using trash method.', function () {
        // Arrange:
        $portfolio = Mockery::mock(PortfolioModel::class);

        // Act:
        $this->write_repository->shouldReceive('trash')
            ->once()
            ->with($portfolio)
            ->andReturn(true);

        $result = $this->service->trash($portfolio);

        // Assert
        expect($result)->toBeTrue();
    });

    it('can restore trashed portfolio when using restore method.', function () {
        // Arrange:
        $portfolio = Mockery::mock(PortfolioModel::class);

        // Act:
        $this->write_repository->shouldReceive('restore')
            ->once()
            ->with($portfolio)
            ->andReturn(true);

        $result = $this->service->restore($portfolio);

        // Assert
        expect($result)->toBeTrue();
    });

    it('can hard delete portfolio when using delete method.', function () {
        // Arrange:
        $portfolio = Mockery::mock(PortfolioModel::class);

        // Expectation:
        $this->write_repository->shouldReceive('delete')
            ->once()
            ->with($portfolio)
            ->andReturn(true);

        // Act:
        $result = $this->service->delete($portfolio);

        // Assert:
        expect($result)->toBeTrue();
    });

});
