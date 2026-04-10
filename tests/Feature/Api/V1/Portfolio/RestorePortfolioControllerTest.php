<?php

use App\Application\Portolio\UseCases\RestorePortfolio;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: RestorePortfolioController', function () {

    describe('Positives', function () {

        it('can restore trashed portfolio resource when using /api/v1/portfolios/{portfolio} PATCH api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->trashed()->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->patchJson(sprintf('/api/v1/portfolios/%s', $portfolio->id));

            // Assert:
            $this->assertNotSoftDeleted($portfolio);

            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'message' => __('messages.success.restored', ['record' => 'Portfolio']),
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/portfolios/{portfolio} PATCH api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->trashed()->create();

            // Act:
            $response = $this->patchJson(sprintf('/api/v1/portfolios/%s', $portfolio->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/portfolios/{portfolio} PATCH api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->hasPortfolios()->create();
            $other_portfolio = PortfolioModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->patchJson(sprintf('/api/v1/portfolios/%s', $other_portfolio->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthorized.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/portfolios/{portfolio} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $portfolio = PortfolioModel::factory()->trashed()->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->patchJson(sprintf('/api/v1/portfolios/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Portfolio] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/portfolios/{portfolio} PATCH api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            // Expectation:
            $this->mock(RestorePortfolio::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($portfolio->user)->patchJson(sprintf('/api/v1/portfolios/%s', $portfolio->id));

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
