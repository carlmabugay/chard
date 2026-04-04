<?php

use App\Models\Strategy as StrategyModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: TrashStrategyController', function () {

    it('should soft delete a strategy resource when using /api/v1/strategies/{id} DELETE api endpoint.', function () {

        // Arrange:
        $strategy = StrategyModel::factory()->create();

        Sanctum::actingAs($strategy->user);

        // Act:
        $response = $this->delete(sprintf('/api/v1/strategies/%s', $strategy->id));

        // Assert:
        $this->assertSoftDeleted($strategy);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);

    });

});
