<?php

use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: ListPortfolioController', function () {

    it('should return collection of authenticated user\'s portfolio resource when using /api/v1/portfolios GET api endpoint.', function () {

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

    it('should return empty data and 0 total record when no records found upon using /api/v1/portfolios GET api endpoint.', function () {

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
