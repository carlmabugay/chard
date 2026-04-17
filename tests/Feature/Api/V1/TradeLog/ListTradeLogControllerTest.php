<?php

use App\Application\TradeLog\UseCases\ListTradeLogs;
use App\Models\Portfolio as PortfolioModel;
use App\Models\TradeLog as TradeLogModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: ListTradeLogController', function () {

    describe('Positives', function () {

        it('can return collection of trade logs resource when using /api/v1/trade_logs GET api endpoint.', function () {
            // Arrange:
            $no_of_trade_logs = 15;
            $portfolio = PortfolioModel::factory()->create();

            TradeLogModel::factory($no_of_trade_logs)->for($portfolio)->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->getJson('/api/v1/trade_logs');

            // Assert:
            $response->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('pagination.total', $no_of_trade_logs);
        });

        it('can return empty data and 0 total record when no records found upon using /api/v1/trade_logs GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/trade_logs');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [],
                ]);
        });
    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/trade_logs GET api endpoint.', function () {
            // Arrange:

            // Act:
            $response = $this->getJson('/api/v1/trade_logs');

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can handle server error response when using /api/v1/trade_logs GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListTradeLogs::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/trade_logs');

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
