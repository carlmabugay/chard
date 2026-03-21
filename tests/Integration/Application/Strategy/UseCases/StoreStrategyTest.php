<?php

use App\Application\Strategy\DTOs\StoreStrategyDTO;
use App\Application\Strategy\UseCases\StoreStrategy;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\User as UserModel;

describe('Integration: StoreStrategy Use Case', function () {

    it('should store strategy when using handle method.', function () {

        // Arrange:
        $user = UserModel::factory()->create();

        $dto = StoreStrategyDTO::fromRequest([
            'user_id' => $user->id,
            'name' => 'Trend Following',
        ]);

        $strategy_entity = new Strategy(
            user_id: $dto->userId(),
            name: $dto->name(),
        );

        $service = Mockery::mock(StrategyService::class);

        // Expectation:
        $service->shouldReceive('store')
            ->once()
            ->andReturn($strategy_entity);

        // Act:
        $use_case = new StoreStrategy($service);
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Strategy::class)
            ->and($result->id())->toBe($strategy_entity->id())
            ->and($result->name())->toBe($strategy_entity->name());
    });
});
