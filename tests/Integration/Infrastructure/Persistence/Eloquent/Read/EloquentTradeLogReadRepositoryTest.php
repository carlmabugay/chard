<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentTradeLogReadRepository;
use App\Models\Portfolio as PortfolioModel;
use App\Models\TradeLog as TradeLogModel;

beforeEach(function () {
    $this->repository = new EloquentTradeLogReadRepository;
});

describe('Integration: EloquentTradeLogReadRepository', function () {

    it('should return all trade logs when using findAll method.', function () {

        // Arrange:
        $no_of_trade_logs = 10;
        $portfolio = PortfolioModel::factory()->create();
        TradeLogModel::factory()->for($portfolio)->count($no_of_trade_logs)->create();

        // Act:
        $result = $this->repository->findAll(new QueryCriteria);

        // Assert:
        expect($result)
            ->toBeArray()
            ->and(expect($result['data'])->toHaveCount($no_of_trade_logs));

    });

});
