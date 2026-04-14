<?php

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Persistence\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Contracts\Persistence\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;

beforeEach(function () {
    $this->write_repository = Mockery::mock(TradeLogWriteRepositoryInterface::class);
    $this->read_repository = Mockery::mock(TradeLogReadRepositoryInterface::class);

    $this->service = new TradeLogService($this->write_repository, $this->read_repository);
});

describe('Unit: TradeLogServiceTest', function () {

    it('can return all trade logs when using findAll method.', function () {
        // Arrange:
        $trade_log = new TradeLog(
            portfolio_id: rand(1, 10),
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

    it('can return a trade log when using findById method.', function () {
        // Arrange:
        $trade_log = new TradeLog(
            portfolio_id: rand(1, 10),
            symbol: 'JFC',
            type: 'buy',
            price: 100,
            shares: 5000,
            fees: 250,
            id: rand(1, 10),
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($trade_log->id())
            ->andReturn($trade_log);

        // Act:
        $result = $this->service->findById($trade_log->id());

        // Assert:
        expect($result)
            ->toBeInstanceOf(TradeLog::class)
            ->and($result->id())->toBe($trade_log->id());
    });

    it('can store trade logs when using store method.', function () {
        // Arrange:
        $dto = new TradeLogDTO(
            portfolio_id: rand(1, 10),
            symbol: 'BPI',
            type: 'buy',
            price: 100,
            shares: 1000,
            fees: 120,
        );

        $trade_log = TradeLog::fromDTO($dto);

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->with($dto)
            ->andReturn($trade_log);

        // Act:
        $result = $this->service->store($dto);

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

    it('can soft delete trade log when using trash method.', function () {
        // Arrange:
        $dto = Mockery::mock(TradeLogDTO::class);

        // Act:
        $this->write_repository->shouldReceive('trash')
            ->once()
            ->with($dto)
            ->andReturn(true);

        $result = $this->service->trash($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

    it('can restore trashed trade log when using restore method.', function () {
        // Arrange:
        $dto = Mockery::mock(TradeLogDTO::class);

        // Expectation:
        $this->write_repository->shouldReceive('restore')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $this->service->restore($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

    it('can hard delete trade log when using delete method.', function () {
        // Arrange:
        $dto = Mockery::mock(TradeLogDTO::class);

        // Expectation:
        $this->write_repository->shouldReceive('delete')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $this->service->delete($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
