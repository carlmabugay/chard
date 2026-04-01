<?php

use App\Models\Portfolio as PortfolioModel;
use App\Models\TradeLog as TradeLogModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: ListTradeLogController', function () {

    it('should return collection of trade logs resource when using /api/v1/trade-logs GET api endpoint.', function () {

        // Arrange:
        $no_of_trade_logs = 15;
        $portfolio = PortfolioModel::factory()->create();

        TradeLogModel::factory($no_of_trade_logs)->for($portfolio)->create();

        Sanctum::actingAs($portfolio->user);

        // Act:
        $response = $this->get('/api/v1/trade-logs');

        dd($response->json());

        // Assert:
        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('pagination.total', $no_of_trade_logs);

    });

});
