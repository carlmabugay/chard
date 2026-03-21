<?php

use App\Application\Strategy\UseCases\GetStrategy;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;

describe('Integration: GetStrategy Use Case', function () {

    it('should return strategy that filtered by id when using handle method.', function () {

        // Arrange:
        $strategy_model = StrategyModel::factory()->create();

        $strategy_entity = Strategy::fromEloquentModel($strategy_model);

        $service = Mockery::mock(StrategyService::class);

        $use_case = new GetStrategy($service);

        // Expectation:
        $service->shouldReceive('fetchById')
            ->once()
            ->with($strategy_model->id)
            ->andReturn($strategy_entity);

        // Act:
        $result = $use_case->handle($strategy_model->id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Strategy::class)
            ->and($result->id())->toBe($strategy_entity->id())
            ->and($result->name())->toBe($strategy_entity->name());

    });
});
