<?php

use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Models\Dividend as DividendModel;
use App\Models\Portfolio as PortfolioModel;

beforeEach(function () {
    $this->repository = new EloquentDividendWriteRepository;
});

describe('Integration: EloquentDividendWriteRepository', function () {

    it('should create new dividend when using store method.', function () {

        // Arrange
        $table = 'dividends';
        $portfolio = PortfolioModel::factory()->create();

        $dividend_entity = new Dividend(
            portfolio_id: $portfolio->id,
            symbol: 'JFC',
            amount: 5000,
            recorded_at: now(),
        );

        // Act:
        $result = $this->repository->store($dividend_entity);

        // Assert:
        expect($result)->toBeInstanceOf(Dividend::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'portfolio_id' => $result->portfolioId(),
            'symbol' => $result->symbol(),
            'amount' => $result->amount(),
            'id' => $result->id(),
            'recorded_at' => $result->recordedAt(),
        ]);

    });

    it('should update dividend when using store method.', function () {

        // Arrange:
        $dividend_model = DividendModel::factory()->create();

        $dividend_entity = new Dividend(
            portfolio_id: $dividend_model->portfolio->id,
            symbol: 'JFC',
            amount: 5000,
            id: $dividend_model->id,
        );

        // Act:
        $result = $this->repository->store($dividend_entity);

        // Assert:
        expect($result)->toBeInstanceOf(Dividend::class);

        $this->assertDatabaseHas('dividends', [
            'portfolio_id' => $result->portfolioId(),
            'symbol' => $result->symbol(),
            'amount' => $result->amount(),
            'id' => $result->id(),
        ]);
    });

    it('should soft delete dividend when using trash method.', function () {

        // Arrange:
        $dividend = DividendModel::factory()->create();

        // Act:
        $this->repository->trash($dividend->id);

        // Assert:
        $this->assertSoftDeleted($dividend);
    });

});
