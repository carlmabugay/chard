<?php

use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: UpdatePortfolioController', function () {

    it('should update existing portfolio resource when using /api/v1/portfolios PUT api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $portfolio = PortfolioModel::factory()->create();
        $new_portfolio_name = 'PH Stock Market';
        $payload = [
            'user_id' => $user->id,
            'id' => $portfolio->id,
            'name' => $new_portfolio_name,
        ];

        // Act:
        Sanctum::actingAs($user);
        $response = $this->put('/api/v1/portfolios', $payload);

        // Assert:
        $this->assertDatabaseHas('portfolios', $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => $new_portfolio_name,
                ],
            ]);
    });
});
