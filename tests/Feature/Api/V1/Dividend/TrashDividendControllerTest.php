<?php

use App\Models\Dividend as DividendModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: TrashDividendController', function () {

    it('should trash existing cash flow resource when using /api/v1/dividend DELETE api endpoint.', function () {

        // Arrange:
        $dividend = DividendModel::factory()->create();

        Sanctum::actingAs($dividend->portfolio->user);

        // Act:
        $response = $this->delete(sprintf('%s/%s', '/api/v1/dividends', $dividend->id));

        // Assert:
        $this->assertSoftDeleted($dividend);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);
    });

});
