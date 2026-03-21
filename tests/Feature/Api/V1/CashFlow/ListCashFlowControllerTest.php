<?php

use App\Models\CashFlow as CashFlowModel;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;

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

    it('should return empty data and 0 total record when no records found upon using /api/v1/cashflows GET api endpoint.',
        function () {

            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/cashflows');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [],
                    'total' => 0,
                ]);
        });

});
