<?php

use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: UpdateStrategyController', function () {

    it('should update existing strategy resource when using /api/v1/strategies PUT api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $strategy = StrategyModel::factory()->create();
        $new_strategy_name = 'Pullback Trading';
        $payload = [
            'id' => $strategy->id,
            'name' => $new_strategy_name,
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
                    'name' => $new_strategy_name,
                ],
            ]);
    });
});
