<?php

use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: StorePortfolioController', function () {

    it('should store new portfolio resource when using /api/v1/portfolios POST api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $portfolio_name = 'PH Stock Market';
        $payload = [
            'name' => $portfolio_name,
        ];

        // Act:
        Sanctum::actingAs($user);
        $response = $this->post('/api/v1/portfolios', $payload);

        // Assert:
        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => $portfolio_name,
                ],
            ]);
    });

});
