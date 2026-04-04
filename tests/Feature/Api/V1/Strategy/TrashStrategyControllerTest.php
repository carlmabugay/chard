<?php

use App\Application\Strategy\UseCases\TrashStrategy;
use App\Models\Strategy as StrategyModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: TrashStrategyController', function () {

    describe('Positives', function () {

        it('should soft delete a strategy resource when using /api/v1/strategies/{id} DELETE api endpoint.',
            function () {

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

    describe('Negatives', function () {

        describe('Negatives', function () {

            it('should handle error message when no record found upon using /api/v1/strategies/{id} GET api endpoint.',
                function () {

                    // Arrange:
                    $random_id = 100;
                    $strategy = StrategyModel::factory()->create();

                    // Act:
                    Sanctum::actingAs($strategy->user);
                    $response = $this->get(sprintf('/api/v1/strategies/%s', $random_id));

                    // Assert:

                    $response->assertNotFound()
                        ->assertJson([
                            'success' => false,
                            'error' => 'Strategy not found',
                            'message' => sprintf('Strategy with ID: %s not found', $random_id),
                        ]);

                });

            it('should handle server error response when using /api/v1/strategies/{id} DELETE api endpoint.',
                function () {

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
                    Sanctum::actingAs($user);
                    $response = $this->delete(sprintf('/api/v1/strategies/%s', $random_id));

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
});
