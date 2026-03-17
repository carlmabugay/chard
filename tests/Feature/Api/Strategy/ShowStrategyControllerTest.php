<?php

use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('Feature: ShowStrategyController', function () {

    it('should return a strategy resource when using /api/v1/strategies/{id} GET api endpoint.', function () {

        // Arrange:
        $user = UserModel::factory()->create();

        $strategy = StrategyModel::factory()
            ->for($user)
            ->create();

        // Act:
        Sanctum::actingAs($user);
        $response = $this->get(sprintf('%s/%s', '/api/v1/strategies', $strategy->id));

        // Assert:
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $strategy->id,
                    'name' => $strategy->name,
                    'created_at' => $strategy->created_at,
                    'updated_at' => $strategy->updated_at,
                ],
            ]);
    });

});
