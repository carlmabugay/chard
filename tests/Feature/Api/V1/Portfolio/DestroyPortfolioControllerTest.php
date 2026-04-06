<?php

use App\Application\Portolio\UseCases\DeletePortfolio;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: DestroyPortfolioController', function () {

    describe('Positives', function () {

        it('can hard delete a strategy resource when using /api/v1/portfolios/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->delete(sprintf('/api/v1/portfolios/%s/destroy', $portfolio->id));

            // Assert:
            $this->assertModelMissing($portfolio);
            $this->assertDatabaseMissing($portfolio);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });
    });

    describe('Negatives', function () {

        it('can handle error message when no record found upon using /api/v1/portfolios/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            // Act:
            $response = $this->delete(sprintf('/api/v1/portfolios/%s/destroy', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Portfolio not found.',
                    'message' => sprintf('Portfolio with ID: [%s] not found.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/portfolios/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            // Expectation:
            $this->mock(DeletePortfolio::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->delete(sprintf('/api/v1/portfolios/%s/destroy', $random_id));

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
