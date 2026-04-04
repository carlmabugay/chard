<?php

use App\Application\TradeLog\UseCases\ListTradeLogs;
use App\Models\Portfolio as PortfolioModel;
use App\Models\TradeLog as TradeLogModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ListTradeLogController', function () {

    describe('Positives', function () {

        it('can return collection of trade logs resource when using /api/v1/trade-logs GET api endpoint.', function () {
            // Arrange:
            $no_of_trade_logs = 15;
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            TradeLogModel::factory($no_of_trade_logs)->for($portfolio)->create();

            // Act:
            $response = $this->get('/api/v1/trade-logs');

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.total', $no_of_trade_logs);
        });

        it('can paginate trade logs when using /api/v1/trade-logs GET api endpoint.', function () {
            // Arrange:
            $no_of_trade_logs = 50;
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            TradeLogModel::factory($no_of_trade_logs)->for($portfolio)->create();

            $page_number = 3;
            $per_page = 15;

            $query = http_build_query([
                'page' => $page_number,
                'per_page' => $per_page,
            ]);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.current_page', $page_number)
                ->assertJsonCount($per_page, 'data');
        });

        it('can filter trade logs by type when using /api/v1/trade-logs GET api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            TradeLogModel::factory()->for($portfolio)->create(['type' => 'buy']);
            TradeLogModel::factory()->for($portfolio)->create(['type' => 'sell']);

            $query = http_build_query([
                'filters' => [
                    ['field' => 'type', 'operator' => '=', 'value' => 'buy'],
                ],
            ]);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.type', 'buy');
        });

        it('can sort trade logs by shares descending when using /api/v1/trade-logs GET api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            TradeLogModel::factory()->for($portfolio)->create(['shares' => 3500]);
            TradeLogModel::factory()->for($portfolio)->create(['shares' => 18000]);
            TradeLogModel::factory()->for($portfolio)->create(['shares' => 290]);

            $query = http_build_query([
                'sorts' => [
                    ['field' => 'shares', 'direction' => 'desc'],
                ],
            ]);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            $data = $response->json('data');

            $shares = collect($data)->map(fn ($item) => $item['shares'])->all();

            // Assert:
            expect($shares)->toBe([18000, 3500, 290]);
        });

        it('can search trade logs by symbol when using /api/v1/trade-logs GET api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            $symbol_to_search = 'BPI';
            TradeLogModel::factory()->for($portfolio)->create(['symbol' => 'AC']);
            TradeLogModel::factory()->for($portfolio)->create(['symbol' => 'JGS']);
            TradeLogModel::factory()->for($portfolio)->create(['symbol' => $symbol_to_search]);
            TradeLogModel::factory()->for($portfolio)->create(['symbol' => 'BDO']);

            $query = http_build_query([
                'search' => $symbol_to_search,
            ]);

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.symbol', $symbol_to_search);
        });

        it('can apply search, filter, sort, and pagination together when using /api/v1/trade-logs GET api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

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

            // Act:
            $response = $this->get(sprintf('/api/v1/trade-logs?%s', $query));

            // Assert
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.type', 'buy')
                ->assertJsonPath('data.0.shares', 290);
        });

    });

    describe('Negatives', function () {

        it('can handle server error response when using /api/v1/trade-logs GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            // Expectation:
            $this->mock(ListTradeLogs::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->get('/api/v1/trade-logs');

            // Assert:
            $response->assertInternalServerError()
                ->assertJson([
                    'success' => false,
                    'error' => 'An unexpected error occurred. Please try again later.',
                    'message' => 'This is a mock exception message.',
                ]);
        });

    });

});
