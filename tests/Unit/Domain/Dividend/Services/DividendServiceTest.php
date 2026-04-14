<?php

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Contracts\Persistence\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Contracts\Persistence\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Domain\Dividend\Services\DividendService;

beforeEach(function () {
    $this->write_repository = Mockery::mock(DividendWriteRepositoryInterface::class);
    $this->read_repository = Mockery::mock(DividendReadRepositoryInterface::class);

    $this->service = new DividendService($this->write_repository, $this->read_repository);
});

describe('Unit: DividendService', function () {

    it('can return all dividends when using findAll method.', function () {
        // Arrange:
        $dividend = new Dividend(
            portfolio_id: rand(1, 10),
            symbol: 'JFC',
            amount: 5000,
        );

        $criteria = new QueryCriteria;

        // Expectation:
        $this->read_repository->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $dividend,
            ]);

        // Act:
        $result = $this->service->findAll($criteria);

        // Assert:
        expect($result)->toBeArray();
    });

    it('can return a dividend when using findById method.', function () {
        // Arrange:
        $dividend = new Dividend(
            portfolio_id: rand(1, 10),
            symbol: 'JFC',
            amount: 5000,
            id: rand(1, 10),
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($dividend->id())
            ->andReturn($dividend);

        // Act:
        $result = $this->service->findById($dividend->id());

        // Assert:
        expect($result)
            ->toBeInstanceOf(Dividend::class)
            ->and($result->id())->toBe($dividend->id());
    });

    it('can store dividend when using store method.', function () {
        // Arrange:
        $dto = new DividendDTO(
            portfolio_id: rand(1, 10),
            symbol: 'JFC',
            amount: 5000,
            recorded_at: now(),
        );

        $dividend = Dividend::fromDTO($dto);

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->andReturn($dividend);

        // Act:
        $result = $this->service->store($dto);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Dividend::class)
            ->and($result->portfolioId())->toBe($dto->portfolioId())
            ->and($result->symbol())->toBe($dto->symbol())
            ->and($result->amount())->toBe($dto->amount())
            ->and($result->recordedAt())->toBe($dto->recordedAt());
    });

    it('can soft delete dividend when using trash method.', function () {
        // Arrange:
        $dto = Mockery::mock(DividendDTO::class);

        // Expectation:
        $this->write_repository->shouldReceive('trash')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $this->service->trash($dto);

        expect($result)->toBeTrue();
    });

    it('can restore trashed dividend when using trash method.', function () {
        // Arrange:
        $dto = Mockery::mock(DividendDTO::class);

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

    it('can hard delete dividend when using delete method.', function () {
        // Arrange:
        $dto = Mockery::mock(DividendDTO::class);

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
