<?php

use App\Application\Strategy\UseCases\GetStrategy;
use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

describe('Integration: GetStrategy Use Case', function () {

    it('can return strategy that filtered by id when using handle method.', function () {
        // Arrange:
        $strategy_model = StrategyModel::factory()->create();

        $strategy_entity = Strategy::fromEloquentModel($strategy_model);

        $use_case = new GetStrategy;

        // Act:
        $result = $use_case->handle($strategy_model);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Strategy::class)
            ->and($result->id())->toBe($strategy_entity->id())
            ->and($result->name())->toBe($strategy_entity->name());
    });

});
