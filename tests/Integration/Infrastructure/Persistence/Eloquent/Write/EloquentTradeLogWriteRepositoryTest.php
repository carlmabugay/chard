<?php

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentTradeLogWriteRepository;
use App\Models\TradeLog as TradeLogModel;

beforeEach(function () {
    $this->repository = new EloquentTradeLogWriteRepository;
});

describe('Integration: EloquentTradeLogWriteRepository', function () {

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
