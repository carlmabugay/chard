<?php

use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Models\Portfolio as PortfolioModel;

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
        $repository = new EloquentDividendWriteRepository;

        $result = $repository->store($dividend_entity);

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
});
