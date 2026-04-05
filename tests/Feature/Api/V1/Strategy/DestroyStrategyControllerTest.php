<?php

use App\Application\Strategy\UseCases\DeleteStrategy;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: DestroyStrategyController', function () {

    describe('Positives', function () {

        it('can soft delete a strategy resource when using /api/v1/strategies/{id}/force DELETE api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();
            Sanctum::actingAs($strategy->user);

            // Act:
            $response = $this->delete(sprintf('/api/v1/strategies/%s/force', $strategy->id));

            // Assert:
            $this->assertModelMissing($strategy);
            $this->assertDatabaseMissing($strategy);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });
    });

    describe('Negatives', function () {

        it('can handle error message when no record found upon using /api/v1/strategies/{id}/force DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $strategy = StrategyModel::factory()->create();

            // Act:
            Sanctum::actingAs($strategy->user);
            $response = $this->delete(sprintf('/api/v1/strategies/%s/force', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Strategy not found to delete.',
                    'message' => sprintf('Strategy with ID: %s not found', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/strategies/{id}/force DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            // Expectation:
            $this->mock(DeleteStrategy::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->delete(sprintf('/api/v1/strategies/%s/force', $random_id));

            // Assert:
            $response->assertInternalServerError()
                ->assertJson([
                    'success' => false,
                    'error' => 'An unexpected error occurred. Please try again later.',
                    'message' => 'This is a mock exception message.',
                ]);
        });

    });

});
