<?php

use App\Models\Portfolio as PortfolioModel;
use App\Models\TradeLog as TradeLogModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: ListTradeLogController', function () {

    describe('Positives', function () {

        it('should return collection of trade logs resource when using /api/v1/trade-logs GET api endpoint.', function () {

            // Arrange:
            $no_of_trade_logs = 15;
            $portfolio = PortfolioModel::factory()->create();

            TradeLogModel::factory($no_of_trade_logs)->for($portfolio)->create();

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get('/api/v1/trade-logs');

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.total', $no_of_trade_logs);

        });

        it('should paginate trade logs when using /api/v1/trade-logs GET api endpoint.', function () {

            // Arrange:
            $no_of_trade_logs = 50;
            $portfolio = PortfolioModel::factory()->create();
            TradeLogModel::factory($no_of_trade_logs)->for($portfolio)->create();

            $page_number = 3;
            $per_page = 15;

            $query = http_build_query([
                'page' => $page_number,
                'per_page' => $per_page,
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.current_page', $page_number)
                ->assertJsonCount($per_page, 'data');

        });

        it('should filter trade logs by type when using /api/v1/trade-logs GET api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            TradeLogModel::factory()->for($portfolio)->create(['type' => 'buy']);
            TradeLogModel::factory()->for($portfolio)->create(['type' => 'sell']);

            $query = http_build_query([
                'filters' => [
                    ['field' => 'type', 'operator' => '=', 'value' => 'buy'],
                ],
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.type', 'buy');

        });

        it('should sort trade logs by shares descending when using /api/v1/trade-logs GET api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            TradeLogModel::factory()->for($portfolio)->create(['shares' => 3500]);
            TradeLogModel::factory()->for($portfolio)->create(['shares' => 18000]);
            TradeLogModel::factory()->for($portfolio)->create(['shares' => 290]);

            $query = http_build_query([
                'sorts' => [
                    ['field' => 'shares', 'direction' => 'desc'],
                ],
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            $data = $response->json('data');

            $shares = collect($data)->map(fn ($item) => $item['shares'])->all();

            // Assert:
            expect($shares)->toBe([18000, 3500, 290]);

        });

        it('should search trade logs by symbol when using /api/v1/cashflows GET api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $symbol_to_search = 'BPI';
            TradeLogModel::factory()->for($portfolio)->create(['symbol' => 'AC']);
            TradeLogModel::factory()->for($portfolio)->create(['symbol' => 'JGS']);
            TradeLogModel::factory()->for($portfolio)->create(['symbol' => $symbol_to_search]);
            TradeLogModel::factory()->for($portfolio)->create(['symbol' => 'BDO']);

            $query = http_build_query([
                'search' => $symbol_to_search,
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.symbol', $symbol_to_search);

        });

        it('should apply search, filter, sort, and pagination together when using /api/v1/trade-logs GET api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            $symbol_to_search = 'BPI';
            TradeLogModel::factory()->for($portfolio)->create(['type' => 'buy', 'symbol' => 'AC', 'shares' => 3500]);
            TradeLogModel::factory()->for($portfolio)->create(['type' => 'sell', 'symbol' => 'JGS', 'shares' => 18000]);
            TradeLogModel::factory()->for($portfolio)->create(['type' => 'buy', 'symbol' => $symbol_to_search, 'shares' => 290]);

            $query = http_build_query([
                'seach' => $symbol_to_search,
                'page' => 1,
                'per_page' => 1,
                'filters' => [
                    ['field' => 'type', 'operator' => '=', 'value' => 'buy'],
                ],
                'sorts' => [
                    ['field' => 'shares', 'direction' => 'asc'],
                ],
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            // Assert
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.type', 'buy')
                ->assertJsonPath('data.0.shares', 290);

        });
    });

});
