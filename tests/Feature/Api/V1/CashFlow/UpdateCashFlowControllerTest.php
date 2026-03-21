<?php

use App\Models\CashFlow as CashFlowModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: UpdateCashFlowController', function () {

    it('should update existing cash flow resource when using /api/v1/cashflows PUT api endpoint.', function () {

        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        $payload = [
            'portfolio_id' => $cash_flow->portfolio->id,
            'type' => $cash_flow->type,
            'amount' => 1000,
            'id' => $cash_flow->id,
        ];

        // Act:
        Sanctum::actingAs($cash_flow->portfolio->user);
        $response = $this->put('/api/v1/cashflows', $payload);

        // Assert:
        $this->assertDatabaseHas('cash_flows', $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'amount' => $payload['amount'],
                ],
            ]);
    });
});
