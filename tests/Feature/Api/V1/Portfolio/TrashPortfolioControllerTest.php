<?php

use App\Application\Portolio\UseCases\TrashPortfolio;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: TrashPortfolioController', function () {

    describe('Positives', function () {

        it('should soft delete portfolio resource when using /api/v1/portfolios DELETE api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->delete(sprintf('%s/%s', '/api/v1/portfolios', $portfolio->id));

            // Assert:
            $this->assertSoftDeleted($portfolio);

            $response->assertOk()
                ->assertJson([
                    'success' => $response,
                ]);
        });

    });

    describe('Negatives', function () {

        it('should handle error message when no record found upon using /api/v1/portfolios/{id} DELETE api endpoint.',
            function () {

                // Arrange:
                $random_id = 100;
                $portfolio = PortfolioModel::factory()->create();

                // Act:
                Sanctum::actingAs($portfolio->user);
                $response = $this->delete(sprintf('/api/v1/portfolios/%s', $random_id));

                // Assert:
                $response->assertNotFound()
                    ->assertJson([
                        'success' => false,
                        'error' => 'Portfolio not found to delete.',
                        'message' => sprintf('Portfolio with ID: %s not found', $random_id),
                    ]);

            });

        it('should handle server error response when using /api/v1/portfolios/{id} DELETE api endpoint.',
            function () {

                // Arrange:
                $random_id = 100;
                $user = UserModel::factory()->create();

                // Expectation:
                $this->mock(TrashPortfolio::class, function (MockInterface $mock) {
                    $mock->shouldReceive('handle')
                        ->once()
                        ->andThrow(new Exception('This is a mock exception message.'));
                });

                // Act:
                Sanctum::actingAs($user);
                $response = $this->delete(sprintf('/api/v1/portfolios/%s', $random_id));

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
