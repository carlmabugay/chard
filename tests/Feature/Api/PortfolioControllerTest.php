<?php

use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: PortfolioController', function () {

    it('returns collection of authenticated user\'s portfolio resource when using /api/v1/portfolios api endpoint.', function () {

        Sanctum::actingAs(
            UserModel::factory()->create()
        );

        $response = $this->get('/api/v1/portfolios');

        $response->assertOk();
        //            ->assertJsonStructure([
        //                'data',
        //            ]);

    });

});
