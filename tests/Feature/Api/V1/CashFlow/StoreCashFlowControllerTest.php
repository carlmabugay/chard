<?php

use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: StoreCashFlowController', function () {

    it('should store new cash flow resource when using /api/v1/cashflows POST api endpoint.', function () {

        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $payload = [
            'portfolio_id' => $portfolio->id,
            'type' => 'deposit',
            'amount' => 100,
        ];

        // Act:
        Sanctum::actingAs($portfolio->user);
        $response = $this->post('/api/v1/cashflows', $payload);

        // Assert:
        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'portfolio_id' => $payload['portfolio_id'],
                    'type' => $payload['type'],
                    'amount' => $payload['amount'],
                ],
            ]);
    });

});
