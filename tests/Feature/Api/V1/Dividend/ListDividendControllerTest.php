<?php

use App\Application\Dividend\UseCases\ListDividends;
use App\Models\Dividend as DividendModel;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: ListDividendController', function () {

    describe('Positives', function () {

        it('can return collection of dividend resource when using /api/v1/dividends GET api endpoint.', function () {
            // Arrange:
            $no_of_dividends = 50;
            $portfolio = PortfolioModel::factory()->create();

            DividendModel::factory($no_of_dividends)->for($portfolio)->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->get('/api/v1/dividends');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [],
                ]);
        });

        it('can paginate dividends when using /api/v1/dividends GET api endpoint.', function () {
            // Arrange:
            $no_of_dividends = 50;
            $portfolio = PortfolioModel::factory()->create();

            DividendModel::factory($no_of_dividends)->for($portfolio)->create();

            $page_number = 2;
            $per_page = 10;

            $query = http_build_query([
                'page' => $page_number,
                'per_page' => $per_page,
            ]);

            // Act:
            $response = $this->actingAs($portfolio->user)->get(sprintf('/api/v1/dividends?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.current_page', $page_number)
                ->assertJsonCount($per_page, 'data');
        });

        it('can sort dividends by amount descending when using /api/v1/dividends GET api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            DividendModel::factory()->for($portfolio)->create(['amount' => 4000]);
            DividendModel::factory()->for($portfolio)->create(['amount' => 2500]);
            DividendModel::factory()->for($portfolio)->create(['amount' => 10200]);

            $query = http_build_query([
                'sorts' => [
                    ['field' => 'amount', 'direction' => 'desc'],
                ],
            ]);

            // Act:
            $response = $this->actingAs($portfolio->user)->get(sprintf('/api/v1/dividends?%s', $query));

            $data = $response->json('data');

            $amounts = collect($data)->map(fn ($item) => $item['amount'])->all();

            // Assert:
            expect($amounts)->toBe([10200, 4000, 2500]);
        });

        it('can search dividends by symbol when using /api/v1/dividends GET api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $symbol_to_search = 'BPI';
            DividendModel::factory()->for($portfolio)->create(['symbol' => 'JFC']);
            DividendModel::factory()->for($portfolio)->create(['symbol' => 'AC']);
            DividendModel::factory()->for($portfolio)->create(['symbol' => $symbol_to_search]);

            $query = http_build_query([
                'search' => $symbol_to_search,
            ]);

            // Act:
            $response = $this->actingAs($portfolio->user)->get(sprintf('/api/v1/dividends?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.symbol', $symbol_to_search);
        });

        it('can apply search, sort, and pagination together when using /api/v1/dividends GET api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            DividendModel::factory()->for($portfolio)->create(['symbol' => 'JFC', 'amount' => 4000]);
            DividendModel::factory()->for($portfolio)->create(['symbol' => 'AC', 'amount' => 2500]);
            DividendModel::factory()->for($portfolio)->create(['symbol' => 'BPI', 'amount' => 10200]);

            $query = http_build_query([
                'search' => 'a',
                'page' => 1,
                'per_page' => 1,
                'sorts' => [
                    ['field' => 'amount', 'direction' => 'desc'],
                ],
            ]);

            // Act:
            $response = $this->actingAs($portfolio->user)->get(sprintf('/api/v1/dividends?%s', $query));

            // Assert
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.symbol', 'AC')
                ->assertJsonPath('data.0.amount', 2500);
        });

    });

    describe('Negatives', function () {

        it('can handle server error response when using /api/v1/dividends GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListDividends::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->get('/api/v1/dividends');

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
