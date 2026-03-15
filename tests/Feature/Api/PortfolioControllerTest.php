<?php

use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: PortfolioController', function () {

    it('returns collection of authenticated user\'s portfolio resource when using /api/v1/portfolios GET api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();

        PortfolioModel::factory()
            ->count(5)
            ->for($user)
            ->create();

        // Act:
        Sanctum::actingAs($user);
        $response = $this->get('/api/v1/portfolios');

        // Assert:
        $response->assertOk()
            ->assertJsonStructure([
                'data',
                'total',
            ]);

    });

    it('should return a portfolio resource when using /api/v1/portfolios/{id} GET api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();

        $portfolio = PortfolioModel::factory()
            ->for($user)
            ->create();

        // Act:
        Sanctum::actingAs($user);
        $response = $this->get('/api/v1/portfolios/'.$portfolio->id);

        // Assert:
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ],
            ]);
    });

});
