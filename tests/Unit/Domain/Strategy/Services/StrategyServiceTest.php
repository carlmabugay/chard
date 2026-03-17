<?php

use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentStrategyReadRepository;

beforeEach(function () {
    $this->read_repository = Mockery::mock(EloquentStrategyReadRepository::class);
    $this->service = new StrategyService($this->read_repository);
});

describe('Unit: Strategy Service', function () {

    it('should return all strategies when using fetchAll method.', function () {

        // Arrange:
        $portfolio = new Strategy(
            user_id: random_int(1, 10),
            name: 'Trend Following',
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
});
