<?php

use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: ListPortfolioController', function () {

    it('should return collection of authenticated user\'s portfolio resource when using /api/v1/portfolios GET api endpoint.',
        function () {

            // Arrange:
            $no_of_portfolio = 5;
            $user = UserModel::factory()->create();

            PortfolioModel::factory()
                ->count($no_of_portfolio)
                ->for($user)
                ->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/portfolios');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [],
                    'total' => $no_of_portfolio,
                ]);

        });

    it('should return empty data and 0 total record when no records found upon using /api/v1/portfolios GET api endpoint.',
        function () {

            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get('/api/v1/portfolios');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [],
                    'total' => 0,
                ]);
        });
});
