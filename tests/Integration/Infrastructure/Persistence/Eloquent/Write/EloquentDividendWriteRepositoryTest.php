<?php

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Models\Dividend as DividendModel;
use App\Models\Portfolio as PortfolioModel;

beforeEach(function () {
    $this->repository = new EloquentDividendWriteRepository;
});

describe('Integration: EloquentDividendWriteRepository', function () {

    it('can create new dividend when using store method.', function () {
        // Arrange
        $table = 'dividends';
        $portfolio = PortfolioModel::factory()->create();

        $dto = new DividendDTO(
            portfolio_id: $portfolio->id,
            symbol: 'JFC',
            amount: 5000,
            recorded_at: now(),
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(Dividend::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'portfolio_id' => $dto->portfolioId(),
            'symbol' => $dto->symbol(),
            'amount' => $dto->amount(),
            'recorded_at' => $dto->recordedAt(),
        ]);

    });

    it('can update dividend when using store method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->create();

        $dto = new DividendDTO(
            portfolio_id: $dividend->portfolio_id,
            symbol: 'JFC',
            amount: $dividend->amount,
            recorded_at: $dividend->recorded_at,
            id: $dividend->id,
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(Dividend::class);

        $this->assertDatabaseHas('dividends', [
            'portfolio_id' => $dto->portfolioId(),
            'symbol' => $dto->symbol(),
            'amount' => $dto->amount(),
            'recorded_at' => $dto->recordedAt(),
            'id' => $dividend->id,
        ]);
    });

    it('can soft delete dividend when using trash method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->create();

        $dto = DividendDTO::fromModel($dividend);

        // Act:
        $this->repository->trash($dto);

        // Assert:
        $this->assertSoftDeleted($dividend);
    });

    it('can restore trashed dividend when using restore method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->trashed()->create();

        $dto = DividendDTO::fromModel($dividend);

        // Act:
        $this->repository->restore($dto);

        // Assert:
        $this->assertNotSoftDeleted($dividend);
    });

    it('can hard delete dividend when using delete method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->create();

        $dto = DividendDTO::fromModel($dividend);

        // Act:
        $this->repository->delete($dto);

        // Assert:
        $this->assertModelMissing($dividend);
        $this->assertDatabaseMissing($dividend);
    });

});
