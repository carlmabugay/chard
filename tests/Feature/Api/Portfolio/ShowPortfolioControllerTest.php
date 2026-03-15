<?php

use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: ShowPortfolioController', function () {

    describe('Positives', function () {

        it('should return a portfolio resource when using /api/v1/portfolios/{id} GET api endpoint.', function () {

            // Arrange:
            $user = UserModel::factory()->create();

            $portfolio = PortfolioModel::factory()
                ->for($user)
                ->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get(sprintf('%s/%s', '/api/v1/portfolios', $portfolio->id));

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

    describe('Negatives', function () {

        it('should handle error message when no record found upon using /api/v1/portfolios/{id} GET api endpoint.', function () {

            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();

            $portfolio = PortfolioModel::factory()
                ->for($user)
                ->create();

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get(sprintf('/api/v1/portfolios/%s', $random_id));

            // Assert:

            $response->assertNotFound()
                ->assertJson([
                    'error' => 'Portfolio not found',
                    'message' => sprintf('Portfolio with ID: %s not found', $random_id),
                ]);

        });

    });

});
