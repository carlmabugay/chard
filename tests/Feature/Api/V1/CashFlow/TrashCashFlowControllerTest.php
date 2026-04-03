<?php

use App\Models\CashFlow as CashFlowModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: TrashCashFlowController', function () {

    it('should trash existing cash flow resource when using /api/v1/cash-flows DELETE api endpoint.', function () {

        // Arrange:
        $cash_flow = CashFlowModel::factory()->create();

        Sanctum::actingAs($cash_flow->portfolio->user);

        // Act:
        $response = $this->delete(sprintf('%s/%s', '/api/v1/cash-flows', $cash_flow->id));

        // Assert:
        $this->assertSoftDeleted($cash_flow);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);
    });

});
