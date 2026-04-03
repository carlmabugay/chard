<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Contracts\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;

beforeEach(function () {
    $this->write_repository = Mockery::mock(TradeLogWriteRepositoryInterface::class);
    $this->read_repository = Mockery::mock(TradeLogReadRepositoryInterface::class);

    $this->service = new TradeLogService($this->write_repository, $this->read_repository);
});

describe('Unit: TradeLogServiceTest', function () {

    it('should return all trade logs when using findAll method.', function () {

        // Arrange:
        $trade_log = new TradeLog(
            symbol: 'JFC',
            type: 'buy',
            price: 100,
            shares: 100,
            fees: 10
        );

        $criteria = new QueryCriteria;

        // Expectation:
        $this->read_repository->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $trade_log,
            ]);

        // Act:
        $result = $this->service->findAll($criteria);

        // Assert:
        expect($result)->toBeArray();
    });

    it('should return a trade logs when using findById method.', function () {

        // Arrange:
        $random_trade_log_id = rand(1, 10);
        $trade_log = new TradeLog(
            symbol: 'JFC',
            type: 'buy',
            price: 100,
            shares: 5000,
            fees: 250,
            id: $random_trade_log_id,
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($random_trade_log_id)
            ->andReturn($trade_log);

        // Act:
        $result = $this->service->findById($random_trade_log_id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(TradeLog::class)
            ->and($result->id())->toBe($random_trade_log_id);

    });

    it('should store trade logs when using store method.', function () {

        // Arrange:
        $trade_log = new TradeLog(
            symbol: 'BPI',
            type: 'buy',
            price: 100,
            shares: 1000,
            fees: 120,
        );

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->with($trade_log)
            ->andReturn($trade_log);

        // Act:
        $result = $this->service->store($trade_log);

        // Assert:
        expect($result)
            ->toBeInstanceOf(TradeLog::class)
            ->and($result->id())->toBe($trade_log->id());
    });

    it('should soft delete trade logs when using trash method.', function () {

        // Arrange:
        $trade_log = new TradeLog(
            symbol: 'BPI',
            type: 'buy',
            price: 100,
            shares: 1000,
            fees: 120,
            id: rand(1, 10),
        );

        // Act:
        $this->write_repository->shouldReceive('trash')
            ->once()
            ->with($trade_log->id())
            ->andReturn(true);

        $result = $this->service->trash($trade_log->id());

        expect($result)->toBeTrue();
    });
});
