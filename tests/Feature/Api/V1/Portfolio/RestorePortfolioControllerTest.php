<?php

use App\Application\Portolio\UseCases\RestorePortfolio;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: RestorePortfolioController', function () {

    describe('Positives', function () {

        it('can restore trashed portfolio resource when using /api/v1/portfolios PATCH api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->trashed()->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->patchJson(sprintf('/api/v1/portfolios/%s', $portfolio->id));

            // Assert:
            $this->assertNotSoftDeleted($portfolio);

            $response->assertOk()
                ->assertJson([
                    'success' => $response,
                ]);
        });

    });

    describe('Negatives', function () {

        it('can handle error message when no record found upon using /api/v1/portfolios/{id} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $portfolio = PortfolioModel::factory()->trashed()->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->patchJson(sprintf('/api/v1/portfolios/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Portfolio not found.',
                    'message' => sprintf('Portfolio with ID: [%s] not found.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/portfolios/{id} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(RestorePortfolio::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->patchJson(sprintf('/api/v1/portfolios/%s', $random_id));

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
