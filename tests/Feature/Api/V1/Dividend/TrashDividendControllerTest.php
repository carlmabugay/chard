<?php

use App\Application\Dividend\UseCases\TrashDividend;
use App\Models\Dividend as DividendModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: TrashDividendController', function () {

    describe('Positives', function () {

        it('should trash existing cash flow resource when using /api/v1/dividend DELETE api endpoint.', function () {

            // Arrange:
            $dividend = DividendModel::factory()->create();

            Sanctum::actingAs($dividend->portfolio->user);

            // Act:
            $response = $this->delete(sprintf('%s/%s', '/api/v1/dividends', $dividend->id));

            // Assert:
            $this->assertSoftDeleted($dividend);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });

    });

    describe('Negatives', function () {

        it('should handle error message when no record found upon using /api/v1/dividends/{id} DELETE api endpoint.',
            function () {

                // Arrange:
                $random_id = 100;
                $dividend = DividendModel::factory()->create();

                // Act:
                Sanctum::actingAs($dividend->portfolio->user);
                $response = $this->delete(sprintf('/api/v1/dividends/%s', $random_id));

                // Assert:
                $response->assertNotFound()
                    ->assertJson([
                        'success' => false,
                        'error' => 'Dividend not found to delete.',
                        'message' => sprintf('Dividend with ID: %s not found', $random_id),
                    ]);

            });

        it('should handle server error response when using /api/v1/dividends/{id} DELETE api endpoint.',
            function () {

                // Arrange:
                $random_id = 100;
                $user = UserModel::factory()->create();

                // Expectation:
                $this->mock(TrashDividend::class, function (MockInterface $mock) {
                    $mock->shouldReceive('handle')
                        ->once()
                        ->andThrow(new Exception('This is a mock exception message.'));
                });

                // Act:
                Sanctum::actingAs($user);
                $response = $this->delete(sprintf('/api/v1/dividends/%s', $random_id));

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
