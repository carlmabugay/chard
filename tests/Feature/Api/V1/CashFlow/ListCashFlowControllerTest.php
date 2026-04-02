<?php

use App\Application\CashFlow\UserCases\ListCashFlows;
use App\Enums\CashFlowType;
use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ListCashFlowController', function () {

    describe('Positives', function () {

        it('should return collection of cash flow resource when using /api/v1/cash-flows GET api endpoint.', function () {

            // Arrange:
            $no_of_cash_flows = 50;
            $portfolio = PortfolioModel::factory()->create();
            CashFlowModel::factory($no_of_cash_flows)->for($portfolio)->create();

            // Act:
            Sanctum::actingAs($portfolio->user);
            $response = $this->get('/api/v1/cash-flows');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [],
                ]);
        });

        it('should paginate cash flows when using /api/v1/cash-flows GET api endpoint.', function () {

            // Arrange:
            $no_of_cash_flows = 50;
            $portfolio = PortfolioModel::factory()->create();
            CashFlowModel::factory($no_of_cash_flows)->for($portfolio)->create();

            $page_number = 3;
            $per_page = 15;

            $query = http_build_query([
                'page' => $page_number,
                'per_page' => $per_page,
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/cash-flows?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.current_page', $page_number)
                ->assertJsonCount($per_page, 'data');

        });

        it('should filter cash flows by type when using /api/v1/cash-flows GET api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            CashFlowModel::factory()->for($portfolio)->create(['type' => CashFlowType::DEPOSIT]);
            CashFlowModel::factory()->for($portfolio)->create(['type' => CashFlowType::WITHDRAW]);

            $query = http_build_query([
                'filters' => [
                    ['field' => 'type', 'operator' => '=', 'value' => CashFlowType::DEPOSIT->value],
                ],
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/cash-flows?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.type', CashFlowType::DEPOSIT->value);

        });

        it('should sort cash flows by amount descending when using /api/v1/cash-flows GET api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            CashFlowModel::factory()->for($portfolio)->create(['amount' => 300]);
            CashFlowModel::factory()->for($portfolio)->create(['amount' => 100]);
            CashFlowModel::factory()->for($portfolio)->create(['amount' => 200]);

            $query = http_build_query([
                'sorts' => [
                    ['field' => 'amount', 'direction' => 'desc'],
                ],
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/cash-flows?%s', $query));

            $data = $response->json('data');

            $amounts = collect($data)->map(fn ($item) => $item['amount'])->all();

            // Assert:
            expect($amounts)->toBe([300, 200, 100]);

        });

        it('should search cash flows by amount when using /api/v1/cash-flows GET api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $amount_to_search = 3000;
            CashFlowModel::factory()->for($portfolio)->create(['amount' => 5000]);
            CashFlowModel::factory()->for($portfolio)->create(['amount' => 15000]);
            CashFlowModel::factory()->for($portfolio)->create(['amount' => $amount_to_search]);

            $query = http_build_query([
                'search' => $amount_to_search,
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/cash-flows?%s', $query));

            // Assert:
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.amount', $amount_to_search);

        });

        it('should apply search, filter, sort, and pagination together when using /api/v1/cash-flows GET api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $amount_to_search = 100;

            CashFlowModel::factory()->for($portfolio)->create(['type' => CashFlowType::DEPOSIT, 'amount' => 200]);
            CashFlowModel::factory()->for($portfolio)->create(['type' => CashFlowType::WITHDRAW, 'amount' => $amount_to_search]);
            CashFlowModel::factory()->for($portfolio)->create(['type' => CashFlowType::DEPOSIT, 'amount' => 300]);
            CashFlowModel::factory()->for($portfolio)->create(['type' => CashFlowType::DEPOSIT, 'amount' => $amount_to_search]);

            $query = http_build_query([
                'search' => $amount_to_search,
                'page' => 1,
                'per_page' => 1,
                'filters' => [
                    ['field' => 'type', 'operator' => '=', 'value' => CashFlowType::DEPOSIT->value],
                ],
                'sorts' => [
                    ['field' => 'amount', 'direction' => 'desc'],
                ],
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/cash-flows?%s', $query));

            // Assert
            $response->assertOk()
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.type', CashFlowType::DEPOSIT->value)
                ->assertJsonPath('data.0.amount', 100);

        });

        it('should return empty data and 0 total record when no records found upon using /api/v1/cash-flows GET api endpoint.',
            function () {

                // Arrange:
                $user = UserModel::factory()->create();

                // Act:
                Sanctum::actingAs($user);
                $response = $this->get('/api/v1/cash-flows');

                // Assert:
                $response->assertOk()
                    ->assertJson([
                        'data' => [],
                    ]);
            });

    });

    describe('Negatives', function () {

        it('should handle server error response when using /api/v1/cash-flows GET api endpoint.', function () {

            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListCashFlows::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/cash-flows');

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
