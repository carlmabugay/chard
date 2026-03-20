<?php

use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

beforeEach(function () {});

describe('Feature: ListCashFlowController', function () {

    it('should return collection of authenticated user\'s cash flow resource when using /api/v1/cashflows GET api endpoint.',
        function () {

            // Arrange:
            $no_of_cash_flow = 5;
            $portfolio = PortfolioModel::factory()->create();
            CashFlowModel::factory()->count($no_of_cash_flow)->create([
                'portfolio_id' => $portfolio->id,
            ]);

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->get('/api/v1/cashflows');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [],
                    'total' => $no_of_cash_flow,
                ]);
        });

});
