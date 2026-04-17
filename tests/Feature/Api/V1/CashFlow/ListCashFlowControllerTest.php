<?php

use App\Application\CashFlow\UserCases\ListCashFlows;
use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: ListCashFlowController', function () {

    describe('Positives', function () {

        it('can return collection of cash flow resource when using /api/v1/cash_flows GET api endpoint.', function () {
            // Arrange:
            $no_of_cash_flows = 50;
            $portfolio = PortfolioModel::factory()->create();

            CashFlowModel::factory($no_of_cash_flows)->for($portfolio)->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->getJson('/api/v1/cash_flows');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [],
                ]);
        });

        it('can return empty data and 0 total record when no records found upon using /api/v1/cash_flows GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Act:

            $response = $this->actingAs($user)->getJson('/api/v1/cash_flows');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/cash_flows GET api endpoint.', function () {
            // Arrange:

            // Act:
            $response = $this->getJson('/api/v1/cash_flows');

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can handle server error response when using /api/v1/cash_flows GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListCashFlows::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/cash_flows');

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
