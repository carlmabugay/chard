<?php

use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: ShowCashFlowController', function () {

    it('should return a cash flow resource when using /api/v1/cashflows/{id} GET api endpoint.', function () {

        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $cash_flow = CashFlowModel::factory()
            ->for($portfolio)
            ->create();

        // Act:
        Sanctum::actingAs($portfolio->user);
        $response = $this->get(sprintf('%s/%s', '/api/v1/cashflows', $cash_flow->id));

        // Assert:
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'portfolio_id' => $cash_flow->portfolio_id,
                    'id' => $cash_flow->id,
                    'type' => $cash_flow->type,
                    'amount' => $cash_flow->amount,
                    'created_at' => $cash_flow->created_at,
                    'updated_at' => $cash_flow->updated_at,
                ],
            ]);

    });

});
