<?php

use App\Application\TradeLog\DTOs\StoreTradeLogDTO;
use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: StoreTradeLog Use Case', function () {

    it('can store trade log when using handle method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $dto = StoreTradeLogDTO::fromRequest([
            'portfolio_id' => $portfolio->id,
            'symbol' => 'BPI',
            'type' => 'buy',
            'price' => 100,
            'shares' => 1000,
            'fees' => 120,
        ]);

        $trade_log_entity = TradeLog::fromDTO($dto);

        $service = Mockery::mock(TradeLogService::class);

        $use_case = new StoreTradeLog($service);

        // Expectation:
        $service->shouldReceive('store')
            ->once()
            ->andReturn($trade_log_entity);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)
            ->toBeInstanceOf(TradeLog::class)
            ->and($result->id())->toBe($trade_log_entity->id());
    });

});
