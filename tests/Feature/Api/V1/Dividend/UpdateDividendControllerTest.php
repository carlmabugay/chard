<?php

use App\Models\Dividend as DividendModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: UpdateDividendController', function () {

    it('should update existing cash flow resource when using /api/v1/dividends PUT api endpoint.', function () {

        // Arrange:
        $dividend = DividendModel::factory()->create();

        $payload = [
            'portfolio_id' => $dividend->portfolio->id,
            'symbol' => $dividend->symbol,
            'amount' => 1000,
            'id' => $dividend->id,
            'recorded_at' => $dividend->recorded_at->toDateTimeString(),
        ];

        // Act:
        Sanctum::actingAs($dividend->portfolio->user);
        $response = $this->put('/api/v1/dividends', $payload);

        // Assert:
        $this->assertDatabaseHas('dividends', $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'amount' => $payload['amount'],
                ],
            ]);
    });

});
