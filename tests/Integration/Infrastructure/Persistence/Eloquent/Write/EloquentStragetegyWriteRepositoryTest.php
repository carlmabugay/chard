<?php

use App\Domain\Strategy\Entities\Strategy;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentStrategyWriteRepository;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;

beforeEach(function () {
    $this->repository = new EloquentStrategyWriteRepository;
});

describe('Integration: EloquentStrategyWriteRepository', function () {

    it('can create new strategy when using store method.', function () {

        // Arrange
        $table = 'strategies';
        $user = UserModel::factory()->create();

        $strategy = new Strategy(
            user_id: $user->id,
            name: 'Trend Following',
        );

        // Act:
        $result = $this->repository->store($strategy);

        // Assert:
        expect($result)->toBeInstanceOf(Strategy::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'user_id' => $strategy->userId(),
            'name' => $strategy->name(),
        ]);
    });

    it('can update strategy when using store method.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $strategy_model = StrategyModel::factory()->create();

        $strategy_entity = new Strategy(
            user_id: $user->id,
            name: 'Pullback Trading',
            id: $strategy_model->id,
        );

        // Act:
        $result = $this->repository->store($strategy_entity);

        // Assert:
        expect($result)->toBeInstanceOf(Strategy::class);

        $this->assertDatabaseHas('strategies', [
            'user_id' => $strategy_entity->userId(),
            'name' => $strategy_entity->name(),
        ]);
    });

    it('can soft delete strategy when using trash method.', function () {

        // Arrange:
        $strategy = StrategyModel::factory()->create();

        // Act:
        $this->repository->trash($strategy->id);

        // Assert:
        $this->assertSoftDeleted($strategy);
    });

});
