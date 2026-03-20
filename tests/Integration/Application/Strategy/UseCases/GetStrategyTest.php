<?php

use App\Application\Strategy\UseCases\GetStrategy;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: Get Strategy', function () {

    it('should return strategy that filtered by id when using handle method.', function () {

        // Arrange:
        $strategy_model = StrategyModel::factory()->create();

        $strategy_entity = new Strategy(
            user_id: $strategy_model->user_id,
            name: $strategy_model->name,
            id: $strategy_model->id,
            created_at: $strategy_model->created_at,
            updated_at: $strategy_model->updated_at,
        );

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
            ->and($result->name())->toBe($strategy_entity->name());

    });
});
