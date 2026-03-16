<?php

use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: UpdatePortfolioController', function () {

    it('should update existing portfolio resource when using /api/v1/portfolios PUT api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $portfolio = PortfolioModel::factory()->create();
        $payload = [
            'id' => $portfolio->id,
            'name' => 'New Portfolio Name',
        ];

        // Act:
        Sanctum::actingAs($user);
        $response = $this->put('/api/v1/portfolios', $payload);

        // Assert:
        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);
    });
});
