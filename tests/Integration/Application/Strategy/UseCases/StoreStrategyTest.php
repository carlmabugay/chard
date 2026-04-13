<?php

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Application\Strategy\UseCases\StoreStrategy;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\User as UserModel;

describe('Integration: StoreStrategy Use Case', function () {

    it('can store strategy when using handle method.', function () {
        // Arrange:
        $user = UserModel::factory()->create();

        $dto = new StrategyDTO(
            user_id: $user->id,
            name: 'Trend Following',
        );

        $strategy_entity = Strategy::fromDTO($dto);

        $service = Mockery::mock(StrategyService::class);

        $use_case = new StoreStrategy($service);

        // Expectation:
        $service->shouldReceive('store')
            ->once()
            ->andReturn($strategy_entity);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Strategy::class)
            ->and($result->id())->toBe($strategy_entity->id())
            ->and($result->name())->toBe($strategy_entity->name());
    });

});
