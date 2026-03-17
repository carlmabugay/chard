<?php

use App\Domain\Strategy\Entities\Strategy;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentStrategyReadRepository;
use App\Models\Strategy as StrategyModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->repository = new EloquentStrategyReadRepository;
});

describe('Integration: EloquentStrategyReadRepository', function () {

    it('should return all strategies when using fetchAll method.', function () {

        // Arrange:
        $count = 10;
        StrategyModel::factory(10)->create();

        // Act:
        $strategies = $this->repository->fetchAll();

        // Assert:
        expect($strategies)
            ->toBeArray()
            ->toHaveCount($count);

    });

    it('should return a strategy when using fetchById method.', function () {

        // Arrange:
        $strategy_model = StrategyModel::factory()->create();

        // Act:
        $strategy_entity = $this->repository->fetchById($strategy_model->id);

        // Assert:
        expect($strategy_entity)
            ->toBeInstanceOf(Strategy::class)
            ->and($strategy_entity->id())->toBe($strategy_model->id);
    });

});
