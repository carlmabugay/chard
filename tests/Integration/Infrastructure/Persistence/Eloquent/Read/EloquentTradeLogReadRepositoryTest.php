<?php

use App\Domain\Common\Query\Filter;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Common\Query\Sort;
use App\Enums\OperatorType;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentTradeLogReadRepository;
use App\Models\Portfolio as PortfolioModel;
use App\Models\TradeLog as TradeLogModel;

beforeEach(function () {
    $this->repository = new EloquentTradeLogReadRepository;
});

describe('Integration: EloquentTradeLogReadRepository', function () {

    describe('Positives', function () {

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

        it('should paginate correctly when using findAll method.', function () {

            // Arrange:
            $no_of_trade_logs = 50;
            TradeLogModel::factory($no_of_trade_logs)->create();

            $page_number = 2;
            $per_page = 10;

            $criteria = new QueryCriteria(
                page: $page_number,
                per_page: $per_page,
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            // Assert:
            expect($result)
                ->toBeArray()
                ->and(expect($result['pagination']['current_page'])->toBe($page_number))
                ->and(count($result['data']))->toBe($per_page);

        });

        it('should filter by type when using findAll method.', function () {

            // Arrange:
            TradeLogModel::factory()->create(['type' => 'buy']);
            TradeLogModel::factory()->create(['type' => 'sell']);

            $criteria = new QueryCriteria(
                filters: [
                    new Filter('type', OperatorType::EQ->value, 'buy'),
                ]
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            // Assert:
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->type())
                ->toBe('buy');

        });

        it('should sort by shares descending when using findAll method.', function () {

            // Arrange:
            TradeLogModel::factory()->create(['shares' => 3500]);
            TradeLogModel::factory()->create(['shares' => 18000]);
            TradeLogModel::factory()->create(['shares' => 290]);

            $criteria = new QueryCriteria(
                sorts: [
                    new Sort('shares', 'desc'),
                ]
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            $shares = collect($result['data'])->map(fn ($item) => $item->shares())->all();

            // Assert
            expect($shares)->toBe([18000, 3500, 290]);

        });

        it('should search by symbol when using findAll method.', function () {

            // Arrange:
            $symbol_to_search = 'BPI';
            TradeLogModel::factory()->create(['symbol' => 'AC']);
            TradeLogModel::factory()->create(['symbol' => 'JGS']);
            TradeLogModel::factory()->create(['symbol' => $symbol_to_search]);
            TradeLogModel::factory()->create(['symbol' => 'BDO']);

            $criteria = new QueryCriteria(
                search: $symbol_to_search
            );

            // Act
            $result = $this->repository->findAll($criteria);

            // Assert
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->symbol())
                ->toBe($symbol_to_search);

        });

        it('should apply search, filter, sort, and pagination together when using findAll method.', function () {

            // Arrange:
            $symbol_to_search = 'BPI';
            TradeLogModel::factory()->create(['type' => 'buy', 'symbol' => 'AC', 'shares' => 3500]);
            TradeLogModel::factory()->create(['type' => 'sell', 'symbol' => 'JGS', 'shares' => 18000]);
            TradeLogModel::factory()->create(['type' => 'buy', 'symbol' => $symbol_to_search, 'shares' => 290]);

            $criteria = new QueryCriteria(
                page: 1,
                per_page: 1,
                search: $symbol_to_search,
                filters: [
                    new Filter('type', OperatorType::EQ->value, 'buy'),
                ],
                sorts: [
                    new Sort('shares', 'asc'),
                ]
            );

            // Act:
            $result = $this->repository->findAll($criteria);

            // Assert
            expect($result['data'])
                ->toHaveCount(1)
                ->and($result['data'][0]->type())
                ->toBe('buy')
                ->and($result['data'][0]->shares())
                ->toBe(290);

        });
    });

});
