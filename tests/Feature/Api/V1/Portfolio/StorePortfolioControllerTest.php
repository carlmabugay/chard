<?php

use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: StorePortfolioController', function () {

    it('should store new portfolio resource when using /api/v1/portfolios POST api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();

        $payload = [
            'user_id' => $user->id,
            'name' => 'PH Stock Market',
        ];

        // Act:
        Sanctum::actingAs($user);
        $response = $this->post('/api/v1/portfolios', $payload);

        // Assert:
        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => $payload['name'],
                ],
            ]);
    });

});
