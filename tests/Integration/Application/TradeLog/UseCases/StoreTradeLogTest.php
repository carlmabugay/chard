<?php

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: StoreTradeLog Use Case', function () {

    it('can store trade log when using handle method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $dto = new TradeLogDTO(
            portfolio_id: $portfolio->id,
            symbol: 'BPI',
            type: 'buy',
            price: 100,
            shares: 1000,
            fees: 120,
        );

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
            ->and($result->portfolioId())->toBe($dto->portfolioId())
            ->and($result->symbol())->toBe($dto->symbol())
            ->and($result->type())->toBe($dto->type())
            ->and($result->price())->toBe($dto->price())
            ->and($result->shares())->toBe($dto->shares())
            ->and($result->fees())->toBe($dto->fees());
    });

});
