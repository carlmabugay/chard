<?php

use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Domain\Dividend\Services\DividendService;

beforeEach(function () {

    $this->read_repository = Mockery::mock(DividendReadRepositoryInterface::class);

    $this->service = new DividendService($this->read_repository);
});

describe('Unit: DividendService', function () {

    it('should return all dividends when using findAll method.', function () {

        // Arrange:
        $dividend = new Dividend(
            portfolio_id: rand(1, 10),
            symbol: 'JFC',
            amount: 5000,
        );

        // Expectation:
        $this->read_repository->shouldReceive('findAll')
            ->once()
            ->andReturn([
                $dividend,
            ]);

        // Act:
        $result = $this->service->findAll();

        // Assert:
        expect($result)->toBeArray();
    });

    it('should return a cash flows when using findById method.', function () {

        // Arrange:
        $random_dividend_id = rand(1, 10);
        $dividend = new Dividend(
            portfolio_id: rand(1, 10),
            symbol: 'JFC',
            amount: 5000,
            id: $random_dividend_id,
        );

        // Expectation:
        $this->read_repository->shouldReceive('findById')
            ->once()
            ->with($random_dividend_id)
            ->andReturn($dividend);

        // Act:
        $result = $this->service->findById($random_dividend_id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Dividend::class)
            ->and($result->id())->toBe($random_dividend_id);

    });

});
