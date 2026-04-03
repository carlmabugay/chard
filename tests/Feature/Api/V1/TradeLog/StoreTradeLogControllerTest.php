<?php

use App\Models\Portfolio as PortfolioModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: StoreTradeLogController', function () {

    it('should store new trade log resource when using /api/v1/trade-logs POST api endpoint.', function () {

        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $payload = [
            'portfolio_id' => $portfolio->id,
            'symbol' => 'BPI',
            'type' => 'buy',
            'price' => 100,
            'shares' => 1000,
            'fees' => 120,
        ];

        // Act:
        Sanctum::actingAs($portfolio->user);
        $response = $this->post('/api/v1/trade-logs', $payload);

        // Assert:
        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'symbol' => $payload['symbol'],
                    'type' => $payload['type'],
                    'price' => $payload['price'],
                    'shares' => $payload['shares'],
                    'fees' => $payload['fees'],
                    'portfolio' => [
                        'id' => $payload['portfolio_id'],
                    ],
                ],
            ]);
    });

});
