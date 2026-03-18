<?php

use App\Domain\Strategy\Entities\Strategy;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentStrategyWriteRepository;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: EloquentStrategyWriteRepository', function () {

    it('should create new strategy when using store method.', function () {

        // Arrange
        $table = 'strategies';
        $user = UserModel::factory()->create();
        $strategy_name = 'Trend Following';

        $strategy = new Strategy(
            user_id: $user->id,
            name: $strategy_name,
        );

        // Act:
        $repository = new EloquentStrategyWriteRepository;

        $stored_strategy = $repository->store($strategy);

        // Assert:
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'user_id' => $user->id,
            'name' => $strategy_name,
        ]);

        expect($stored_strategy)->toBeInstanceOf(Strategy::class);
    });

    it('should update strategy when using store method.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $strategy_model = StrategyModel::factory()->create();
        $new_strategy_name = 'Pullback Trading';

        $strategy_entity = new Strategy(
            user_id: $user->id,
            name: $new_strategy_name,
            id: $strategy_model->id,
        );

        // Act:
        $repository = new EloquentStrategyWriteRepository;

        $updated_strategy = $repository->store($strategy_entity);

        // Assert:
        $this->assertDatabaseHas('strategies', [
            'user_id' => $user->id,
            'id' => $strategy_model->id,
            'name' => $new_strategy_name,
        ]);

        expect($updated_strategy)->toBeInstanceOf(Strategy::class);
    });

});
