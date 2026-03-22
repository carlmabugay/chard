<?php

use App\Models\Dividend as DividendModel;
use App\Models\Portfolio as PortfolioModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: ListDividendController', function () {

    it('should return collection of authenticated user\'s dividend resource when using /api/v1/dividends GET api endpoint.', function () {

        // Arrange:
        $no_of_dividends = 5;
        $portfolio = PortfolioModel::factory()->create();
        DividendModel::factory()->count($no_of_dividends)->create([
            'portfolio_id' => $portfolio->id,
        ]);

        // Act:
        Sanctum::actingAs($portfolio->user);
        $response = $this->get('/api/v1/dividends');

        // Assert:
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [],
                'total' => $no_of_dividends,
            ]);

    });
});
