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
        $id = rand(1, 10);

        $strategy = new Strategy(
            user_id: rand(1, 10),
            name: 'Trend Following',
            id: $id,
        );

        // Expectation:
        $this->read_repository->shouldReceive('fetchById')
            ->once()
            ->with($id)
            ->andReturn($strategy);

        // Act:
        $result = $this->service->fetchById($id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Strategy::class)
            ->and($result->id())->toBe($id);

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
        $stored_strategy = $this->service->store($strategy);

        // Assert
        expect($stored_strategy)->toBeInstanceOf(Strategy::class);
    });

});
