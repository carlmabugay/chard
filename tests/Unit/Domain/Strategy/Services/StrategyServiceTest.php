<?php

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

    it('should return all strategies when using fetchAll method.', function () {

        // Arrange:
        $strategy = new Strategy(
            user_id: rand(1, 10),
            name: 'Trend Following',
        );

        // Expectation:
        $this->read_repository->shouldReceive('fetchAll')
            ->once()
            ->andReturn([
                $strategy,
            ]);

        // Act:
        $result = $this->service->fetchAll();

        // Assert:
        expect($result)->toBeArray();
    });

    it('should return a strategy when using fetchById method.', function () {

        // Arrange:
        $random_strategy_id = rand(1, 10);

        $strategy = new Strategy(
            user_id: rand(1, 10),
            name: 'Trend Following',
            id: $random_strategy_id,
        );

        // Expectation:
        $this->read_repository->shouldReceive('fetchById')
            ->once()
            ->with($random_strategy_id)
            ->andReturn($strategy);

        // Act:
        $result = $this->service->fetchById($random_strategy_id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Strategy::class)
            ->and($result->id())->toBe($random_strategy_id);

    });

    it('should store strategy when using store method.', function () {

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

});
