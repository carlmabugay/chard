<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Contracts\Write\DividendWriteRepositoryInterface;
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
        $dividend = new Dividend(
            portfolio_id: rand(1, 10),
            symbol: 'JFC',
            amount: 5000,
        );

        // Expectation:
        $this->write_repository->shouldReceive('store')
            ->once()
            ->andReturn($dividend);

        // Act:
        $result = $this->service->store($dividend);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Dividend::class)
            ->and($result->id())->toBe($dividend->id());
    });

    it('can soft delete dividend when using trash method.', function () {
        // Arrange:
        $dividend = new Dividend(
            portfolio_id: rand(1, 10),
            symbol: 'JFC',
            amount: 5000,
            id: rand(1, 10),
        );

        // Act:
        $this->write_repository->shouldReceive('trash')
            ->once()
            ->with($dividend->id())
            ->andReturn(true);

        $result = $this->service->trash($dividend->id());

        expect($result)->toBeTrue();
    });

});
