<?php

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

});
