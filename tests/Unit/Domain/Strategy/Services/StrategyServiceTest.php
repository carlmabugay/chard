<?php

use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentStrategyReadRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentStrategyWriteRepository;

beforeEach(function () {
    $this->write_repository = Mockery::mock(EloquentStrategyWriteRepository::class);
    $this->read_repository = Mockery::mock(EloquentStrategyReadRepository::class);

    $this->service = new StrategyService($this->write_repository, $this->read_repository);
});

describe('Unit: Strategy Service', function () {

    it('should return all strategies when using fetchAll method.', function () {

        // Arrange:
        $strategy = new Strategy(
            user_id: random_int(1, 10),
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
        $id = random_int(1, 10);

        $strategy = new Strategy(
            user_id: random_int(1, 10),
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
            user_id: random_int(1, 10),
            name: 'Trend Following',
        );

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->with($strategy);

        // Act:
        $stored_strategy = $this->service->store($strategy);

        expect($stored_strategy)->toBeInstanceOf(Strategy::class);
    });

});
