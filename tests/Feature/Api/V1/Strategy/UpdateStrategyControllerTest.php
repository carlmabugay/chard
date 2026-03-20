<?php

use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: UpdateStrategyController', function () {

    it('should update existing strategy resource when using /api/v1/strategies PUT api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $strategy = StrategyModel::factory()->create();

        $payload = [
            'user_id' => $user->id,
            'id' => $strategy->id,
            'name' => 'Pullback Trading',
        ];

        // Act:
        Sanctum::actingAs($user);
        $response = $this->put('/api/v1/strategies', $payload);

        // Assert:
        $this->assertDatabaseHas('strategies', $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => $payload['name'],
                ],
            ]);
    });
});
