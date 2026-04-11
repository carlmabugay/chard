<?php

use App\Application\Strategy\UseCases\ListStrategies;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Contracts\StrategyServiceInterface;
use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

describe('Integration: ListStrategies Use Case', function () {

    it('can list all strategies when using handle method.', function () {
        // Arrange:
        $no_of_strategies = 10;
        $strategy_model = StrategyModel::factory($no_of_strategies)->create();
        $strategy_entity = $strategy_model->map(fn (StrategyModel $model) => Strategy::fromEloquentModel($model))->all();

        $service = Mockery::mock(StrategyServiceInterface::class);
        $criteria = Mockery::mock(QueryCriteria::class);

        $use_case = new ListStrategies($service);

        $service->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $strategy_entity,
            ]);

        // Act:
        $result = $use_case->handle($criteria);

        // Assert:
        expect($result)
            ->toBeArray()
            ->and(count($strategy_entity))->toEqual($no_of_strategies);
    });

});
