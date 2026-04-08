<?php

use App\Application\Strategy\UseCases\TrashStrategy;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: TrashStrategyController', function () {

    describe('Positives', function () {

        it('can soft delete a strategy resource when using /api/v1/strategies/{id}/trash DELETE api endpoint.', function () {
            // Arrange:
            $strategy = StrategyModel::factory()->create();

            // Act:
            $response = $this->actingAs($strategy->user)->delete(sprintf('/api/v1/strategies/%s/trash', $strategy->id));

            // Assert:
            $this->assertSoftDeleted($strategy);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });
    });

    describe('Negatives', function () {

        it('can handle error message when no record found upon using /api/v1/strategies/{id}/trash DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $strategy = StrategyModel::factory()->create();

            // Act:
            $response = $this->actingAs($strategy->user)->delete(sprintf('/api/v1/strategies/%s/trash', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Strategy not found.',
                    'message' => sprintf('Strategy with ID: [%s] not found.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/strategies/{id}/trash DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(TrashStrategy::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->delete(sprintf('/api/v1/strategies/%s/trash', $random_id));

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
