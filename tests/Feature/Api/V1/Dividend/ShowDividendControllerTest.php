<?php

use App\Models\Dividend as DividendModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: ShowDividendController', function () {

    it('should return a dividend resource when using /api/v1/dividends/{id} GET api endpoint.', function () {

        // Arrange:
        $dividend = DividendModel::factory()->create();

        // Act:
        Sanctum::actingAs($dividend->portfolio->user);
        $response = $this->get(sprintf('%s/%s', '/api/v1/dividends', $dividend->id));

        // Assert:
        $response->assertOk()
            ->assertExactJson([
                'success' => true,
                'data' => [
                    'portfolio_id' => $dividend->portfolio_id,
                    'id' => $dividend->id,
                    'symbol' => $dividend->symbol,
                    'amount' => $dividend->amount,
                    'recorded_at' => $dividend->recorded_at->toDateTimeString(),
                ],
            ]);

    });

});
