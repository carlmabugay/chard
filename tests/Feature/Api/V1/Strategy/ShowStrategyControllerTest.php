<?php

use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;

describe('Feature: ShowStrategyController', function () {

    describe('Positives', function () {

        it('can return a strategy resource when using /api/v1/strategies/{strategy} GET api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            // Act:
            $response = $this->actingAs($strategy->user)->getJson(sprintf('/api/v1/strategies/%s', $strategy->id));

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [
                        'id' => $strategy->id,
                        'name' => $strategy->name,
                        'created_at' => $strategy->created_at->format('F d, Y'),
                    ],
                    'success' => true,
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/strategies/{strategy} GET api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            // Act:
            $response = $this->getJson(sprintf('/api/v1/strategies/%s', $strategy->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/strategies/{strategy} GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->hasStrategies()->create();
            $other_strategy = StrategyModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/strategies/%s', $other_strategy->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/strategies/{strategy} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $strategy = StrategyModel::factory()->create();

            // Act:
            $response = $this->actingAs($strategy->user)->getJson(sprintf('/api/v1/strategies/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Strategy] %s.', $random_id),
                ]);
        });

    });

});
