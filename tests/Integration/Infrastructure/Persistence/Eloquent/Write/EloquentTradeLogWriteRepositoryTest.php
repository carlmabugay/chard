<?php

use App\Domain\TradeLog\Entities\TradeLog;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentTradeLogWriteRepository;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: EloquentTradeLogWriteRepository', function () {

    it('should create new trade log when using store method.', function () {

        // Arrange
        $table = 'trade_logs';
        $portfolio = PortfolioModel::factory()->create();

        $trade_log_entity = new TradeLog(
            symbol: 'BPI',
            type: 'buy',
            price: 100,
            shares: 1000,
            fees: 120,
            portfolio_id: $portfolio->id,
        );

        // Act:
        $repository = new EloquentTradeLogWriteRepository;

        $result = $repository->store($trade_log_entity);

        // Assert:
        expect($result)->toBeInstanceOf(TradeLog::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'portfolio_id' => $trade_log_entity->portfolioId(),
            'type' => $trade_log_entity->type(),
            'symbol' => $trade_log_entity->symbol(),
            'price' => $trade_log_entity->price(),
            'shares' => $trade_log_entity->shares(),
            'fees' => $trade_log_entity->fees(),
            'id' => $result->id(),
        ]);

    });
});
