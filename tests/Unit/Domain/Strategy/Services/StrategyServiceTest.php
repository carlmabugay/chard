<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Contracts\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Contracts\Write\StrategyWriteRepositoryInterface;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;

beforeEach(function () {
    $this->write_repository = Mockery::mock(StrategyWriteRepositoryInterface::class);
    $this->read_repository = Mockery::mock(StrategyReadRepositoryInterface::class);

    $this->service = new StrategyService($this->write_repository, $this->read_repository);
});

describe('Unit: StrategyService', function () {

    it('can return all strategies when using findAll method.', function () {
        // Arrange:
        $strategy = new Strategy(
            user_id: rand(1, 10),
            name: 'Trend Following',
        );

        $criteria = new QueryCriteria;

        // Expectation:
        $this->read_repository->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $strategy,
            ]);

        // Act:
        $result = $this->service->findAll($criteria);

        // Assert:
        expect($result)->toBeArray();
    });

    it('can return a strategy when using findById method.', function () {
        // Arrange:
        $strategy = new Strategy(
            user_id: rand(1, 10),
            name: 'Trend Following',
            id: rand(1, 10),
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($strategy->id())
            ->andReturn($strategy);

        // Act:
        $result = $this->service->findById($strategy->id());

        // Assert:
        expect($result)
            ->toBeInstanceOf(Strategy::class)
            ->and($result->id())->toBe($strategy->id());
    });

    it('can store strategy when using store method.', function () {
        // Arrange:
        $strategy = new Strategy(
            user_id: rand(1, 10),
            name: 'Trend Following',
        );

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->with($strategy)
            ->andReturn($strategy);

        // Act:
        $result = $this->service->store($strategy);

        // Assert
        expect($result)
            ->toBeInstanceOf(Strategy::class)
            ->and($result->id())->toBe($strategy->id());
    });

    it('can soft delete strategy when using trash method.', function () {
        // Arrange:
        $strategy = new Strategy(
            user_id: rand(1, 10),
            name: 'Trend Following',
            id: rand(1, 10),
        );

        // Expectation:
        $this->write_repository->shouldReceive('trash')
            ->once()
            ->with($strategy->id())
            ->andReturn(true);

        // Act:
        $result = $this->service->trash($strategy->id());

        // Assert:
        expect($result)->toBeTrue();
    });

    it('can restore trashed strategy when using restore method.', function () {
        // Arrange:
        $strategy = new Strategy(
            user_id: rand(1, 10),
            name: 'Trend Following',
            id: rand(1, 10),
        );

        // Expectation:
        $this->write_repository->shouldReceive('restore')
            ->once()
            ->with($strategy->id())
            ->andReturn(true);

        // Act:
        $result = $this->service->restore($strategy->id());

        // Assert:
        expect($result)->toBeTrue();
    });

});
