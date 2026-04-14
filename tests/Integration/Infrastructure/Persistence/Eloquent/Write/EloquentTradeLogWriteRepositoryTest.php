<?php

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentTradeLogWriteRepository;
use App\Models\Portfolio as PortfolioModel;
use App\Models\TradeLog as TradeLogModel;

beforeEach(function () {
    $this->repository = new EloquentTradeLogWriteRepository;
});

describe('Integration: EloquentTradeLogWriteRepository', function () {

    it('can create new trade log when using store method.', function () {
        // Arrange
        $table = 'trade_logs';
        $portfolio = PortfolioModel::factory()->create();

        $dto = new TradeLogDTO(
            portfolio_id: $portfolio->id,
            symbol: 'BPI',
            type: 'buy',
            price: 100,
            shares: 1000,
            fees: 120,
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(TradeLog::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'portfolio_id' => $dto->portfolioId(),
            'type' => $dto->type(),
            'symbol' => $dto->symbol(),
            'price' => $dto->price(),
            'shares' => $dto->shares(),
            'fees' => $dto->fees(),
        ]);

    });

    it('can update trade log when using store method.', function () {
        // Arrange:
        $trade_log = TradeLogModel::factory()->create();

        $dto = new TradeLogDTO(
            portfolio_id: $trade_log->portfolio_id,
            symbol: $trade_log->symbol,
            type: 'buy',
            price: $trade_log->price,
            shares: 5000,
            fees: $trade_log->fees,
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(TradeLog::class);

        $this->assertDatabaseHas('trade_logs', [
            'portfolio_id' => $dto->portfolioId(),
            'type' => $dto->type(),
            'symbol' => $dto->symbol(),
            'price' => $dto->price(),
            'shares' => $dto->shares(),
            'fees' => $dto->fees(),
        ]);
    });

    it('can soft delete trade log when using trash method.', function () {
        // Arrange:
        $trade_log = TradeLogModel::factory()->create();

        $dto = TradeLogDTO::fromModel($trade_log);

        // Act:
        $this->repository->trash($dto);

        // Assert
        $this->assertSoftDeleted($trade_log);
    });

    it('can restore trashed trade log when using restore method.', function () {
        // Arrange:
        $trade_log = TradeLogModel::factory()->trashed()->create();

        $dto = TradeLogDTO::fromModel($trade_log);

        // Act:
        $this->repository->restore($dto);

        // Assert:
        $this->assertNotSoftDeleted($trade_log);
    });

    it('can hard delete trade log when using delete method.', function () {
        // Arrange:
        $trade_log = TradeLogModel::factory()->create();

        $dto = TradeLogDTO::fromModel($trade_log);

        // Act:
        $this->repository->delete($dto);

        // Assert:
        $this->assertModelMissing($trade_log);
        $this->assertDatabaseMissing($trade_log);
    });

});
