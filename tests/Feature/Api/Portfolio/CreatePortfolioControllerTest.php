<?php

use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: CreatePortfolioController', function () {

    it('should save new portfolio resource when using /api/v1/portfolios POST api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $payload = [
            'name' => 'PH Stock Market',
        ];

        // Act:
        Sanctum::actingAs($user);
        $response = $this->post('/api/v1/portfolios', $payload);

        // Assert:
        $response->assertOk();
    });

});
