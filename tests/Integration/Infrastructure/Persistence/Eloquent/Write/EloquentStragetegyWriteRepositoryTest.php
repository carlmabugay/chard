<?php

use App\Application\Strategy\DTOs\StrategyDTO;
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

        $dto = new StrategyDTO(
            user_id: $user->id,
            name: 'Trend Following',
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(Strategy::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'user_id' => $dto->userId(),
            'name' => $dto->name(),
        ]);
    });

    it('can update strategy when using store method.', function () {
        // Arrange:
        $strategy = StrategyModel::factory()->create();

        $dto = StrategyDTO::fromModel($strategy);

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(Strategy::class);

        $this->assertDatabaseHas('strategies', [
            'user_id' => $dto->userId(),
            'name' => $dto->name(),
        ]);
    });

    it('can soft delete strategy when using trash method.', function () {
        // Arrange:
        $strategy = StrategyModel::factory()->create();

        $dto = StrategyDTO::fromModel($strategy);

        // Act:
        $this->repository->trash($dto);

        // Assert:
        $this->assertSoftDeleted($strategy);
    });

    it('can restore trashed strategy when using restore method.', function () {
        // Arrange:
        $strategy = StrategyModel::factory()->trashed()->create();

        $dto = StrategyDTO::fromModel($strategy);

        // Act:
        $this->repository->restore($dto);

        // Assert:
        $this->assertNotSoftDeleted($strategy);
    });

    it('can hard delete strategy when using delete method.', function () {
        // Arrange:
        $strategy = StrategyModel::factory()->create();

        $dto = StrategyDTO::fromModel($strategy);

        // Act:
        $this->repository->delete($dto);

        // Assert:
        $this->assertModelMissing($strategy);
        $this->assertDatabaseMissing($strategy);
    });

});
