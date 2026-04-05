<?php

use App\Domain\Strategy\Entities\Strategy;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentStrategyWriteRepository;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentStrategyWriteRepository;
});

describe('Integration: EloquentStrategyWriteRepository', function () {

    describe('Positives', function () {

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

        it('can restore trashed strategy when using restore method.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->trashed()->create();

            // Act:
            $this->repository->restore($strategy->id);

            // Assert:
            $this->assertNotSoftDeleted($strategy);
        });

        it('can hard delete strategy when using delete method.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            // Act:
            $this->repository->delete($strategy->id);

            // Assert:
            $this->assertModelMissing($strategy);
            $this->assertDatabaseMissing($strategy);
        });

    });

    describe('Negatives', function () {

        it('can throw an exception when no record found upon using trash method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->trash($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

        it('can throw an exception when no record found upon using restore method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->restore($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

        it('can throw an exception when no record found upon using delete method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->delete($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

    });

});
