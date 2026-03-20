<?php

use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: StoreStrategyController', function () {

    it('should store new strategy resource when using /api/v1/strategies POST api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $strategy_name = 'Trend Following';

        $payload = [
            'name' => $strategy_name,
        ];

        // Act:
        Sanctum::actingAs($user);
        $response = $this->post('/api/v1/strategies', $payload);

        // Assert:
        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => $strategy_name,
                ],
            ]);
    });

});
