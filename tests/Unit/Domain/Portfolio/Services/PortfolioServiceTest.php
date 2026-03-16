<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;

beforeEach(function () {
    $this->read_repository = Mockery::mock(EloquentPortfolioReadRepository::class);
    $this->write_repository = Mockery::mock(EloquentPortfolioWriteRepository::class);
    $this->service = new PortfolioService($this->write_repository, $this->read_repository);

});

describe('Unit: Portfolio Service', function () {

    it('should return all portfolio when using fetchAll method.', function () {

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

    it('should create new portfolio when using store method.', function () {

        // Arrange:
        $portfolio = new Portfolio(
            user_id: random_int(1, 10),
            name: 'PH Stock Market',
        );

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->with($portfolio);

        // Act:
        $this->service->store($portfolio);
    });

});
