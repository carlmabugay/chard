<?php

use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentDividendReadRepository;
use App\Models\Dividend as DividendModel;
use App\Models\Portfolio as PortfolioModel;

beforeEach(function () {
    $this->repository = new EloquentDividendReadRepository;
});

describe('Integration: EloquentDividendReadRepository', function () {

    it('should return all dividends when using findAll method.', function () {

        // Arrange:
        $no_of_dividends = 10;
        $portfolio = PortfolioModel::factory()->create();
        DividendModel::factory()
            ->count($no_of_dividends)
            ->create([
                'portfolio_id' => $portfolio->id,
            ]);

        // Act:
        $result = $this->repository->findAll();

        // Assert:
        expect($result)
            ->toBeArray()
            ->toHaveCount($no_of_dividends);
    });

    it('should return a cash flows when using findById method.', function () {

        // Arrange:
        $dividend = DividendModel::factory()->create();

        // Act:
        $result = $this->repository->findById($dividend->id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Dividend::class)
            ->and($result->id())->toBe($dividend->id);

    });

});
