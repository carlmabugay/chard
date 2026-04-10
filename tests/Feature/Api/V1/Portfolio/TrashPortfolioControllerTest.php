<?php

use App\Application\Portolio\UseCases\TrashPortfolio;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: TrashPortfolioController', function () {

    describe('Positives', function () {

        it('can soft delete portfolio resource when using /api/v1/portfolios/{portfolio}/trash DELETE api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->deleteJson(sprintf('/api/v1/portfolios/%s/trash', $portfolio->id));

            // Assert:
            $this->assertSoftDeleted($portfolio);

            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'message' => __('messages.success.trashed', ['record' => 'Portfolio']),
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/portfolios/{portfolio}/trash DELETE api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            // Act:
            $response = $this->deleteJson(sprintf('/api/v1/portfolios/%s/trash', $portfolio->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/portfolios/{portfolio}/trash DELETE api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->hasPortfolios()->create();
            $other_portfolio = PortfolioModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->deleteJson(sprintf('/api/v1/portfolios/%s/trash', $other_portfolio->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthorized.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/portfolios/{portfolio}/trash DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $portfolio = PortfolioModel::factory()->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->deleteJson(sprintf('/api/v1/portfolios/%s/trash', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Portfolio] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/portfolios/{portfolio}/trash DELETE api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            // Expectation:
            $this->mock(TrashPortfolio::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($portfolio->user)->deleteJson(sprintf('/api/v1/portfolios/%s/trash', $portfolio->id));

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
