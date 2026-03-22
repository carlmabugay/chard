<?php

use App\Models\Portfolio as PortfolioModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: StoreCashFlowController', function () {

    it('should store new cash flow resource when using /api/v1/dividends POST api endpoint.', function () {

        // Arrange:
        $portfolio = PortfolioModel::factory()->create();
        $payload = [
            'portfolio_id' => $portfolio->id,
            'symbol' => 'JFC',
            'amount' => 100,
            'recorded_at' => now()->toDateTimeString(),
        ];

        Sanctum::actingAs($portfolio->user);

        // Act:
        $result = $this->post('/api/v1/dividends', $payload);

        // Assert:
        $result->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'portfolio_id' => $payload['portfolio_id'],
                    'symbol' => $payload['symbol'],
                    'amount' => $payload['amount'],
                    'recorded_at' => $payload['recorded_at'],
                ],
            ]);

    });

});
