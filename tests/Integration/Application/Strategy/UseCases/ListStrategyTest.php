<?php

use App\Application\Strategy\UseCases\ListStrategies;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: List of all Strategies', function () {

    it('should list all strategies when using handle method.', function () {

        // Arrange:
        $count = 10;
        $strategy_model = StrategyModel::factory()->count($count)->create();
        $strategy_entity = $strategy_model->map(fn (StrategyModel $model) => Strategy::fromEloquentModel($model))->all();

        $service = Mockery::mock(StrategyService::class);

        $use_case = new ListStrategies($service);

        $service->shouldReceive('fetchAll')
            ->once()
            ->andReturn([
                $strategy_entity,
            ]);

        // Act:
        $result = $use_case->handle();

        // Assert:
        expect($result)->toBeArray()
            ->and(count($strategy_entity))->toEqual($count);

    });
});
