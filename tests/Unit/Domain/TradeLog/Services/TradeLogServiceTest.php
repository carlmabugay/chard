<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;

beforeEach(function () {
    $this->read_repository = Mockery::mock(TradeLogReadRepositoryInterface::class);

    $this->service = new TradeLogService($this->read_repository);
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
});
