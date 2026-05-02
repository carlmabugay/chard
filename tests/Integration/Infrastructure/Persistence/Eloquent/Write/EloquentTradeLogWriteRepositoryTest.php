<?php

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentTradeLogWriteRepository;
use App\Models\TradeLog as TradeLogModel;

beforeEach(function () {
    $this->repository = new EloquentTradeLogWriteRepository;
});

describe('Integration: EloquentTradeLogWriteRepository', function () {

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
