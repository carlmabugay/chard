<?php

use App\Application\Portolio\UseCases\StorePortfolio;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: UpdatePortfolioController', function () {

    describe('Positives', function () {

        it('can update existing portfolio resource when using /api/v1/portfolios/{portfolio} PUT api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'name' => 'PH Stock Market',
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->putJson(sprintf('/api/v1/portfolios/%s', $portfolio->id), $payload);

            // Assert:
            $this->assertDatabaseHas('portfolios', $payload);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'message' => __('messages.success.updated', ['record' => 'Portfolio']),
                    'data' => [
                        'name' => $payload['name'],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/portfolios/{portfolio} PUT api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'name' => 'PH Stock Market',
            ];

            // Act:
            $response = $this->putJson(sprintf('/api/v1/portfolios/%s', $portfolio->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/portfolios/{portfolio} PUT api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->hasPortfolios()->create();
            $other_portfolio = PortfolioModel::factory()->create();

            $payload = [
                'name' => 'PH Stock Market',
            ];

            // Act:
            $response = $this->actingAs($user)->putJson(sprintf('/api/v1/portfolios/%s', $other_portfolio->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/portfolios/{portfolio} PUT api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $portfolio = PortfolioModel::factory()->create();

            // Act:
            $response = $this->actingAs($portfolio->user)->getJson(sprintf('/api/v1/portfolios/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Portfolio] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/portfolios/{portfolio} PUT api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'name' => 'PH Stock Market',
            ];

            // Expectation:
            $this->mock(StorePortfolio::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($portfolio->user)->putJson(sprintf('/api/v1/portfolios/%s', $portfolio->id), $payload);

            // Assert:
            $response->assertInternalServerError()
                ->assertJson([
                    'success' => false,
                    'error' => 'An unexpected error occurred. Please try again later.',
                    'message' => 'This is a mock exception message.',
                ]);
        });

    });

    describe('Validations', function () {

        it('requires name field when using /api/v1/portfolios/{portfolio} PUT api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [];

            // Act:
            $response = $this->actingAs($user)->postJson('/api/v1/portfolios', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertExactJson([
                    'message' => __('validation.required', ['attribute' => 'name']),
                    'errors' => [
                        'name' => [
                            0 => __('validation.required', ['attribute' => 'name']),
                        ],
                    ],
                ]);
        });

        it('limits name field to 255 characters when using /api/v1/portfolios/{portfolio} PUT api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'name' => fake()->text(500),
            ];

            // Act:
            $response = $this->actingAs($user)->postJson('/api/v1/portfolios', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertExactJson([
                    'message' => __('validation.max.string', ['attribute' => 'name', 'max' => 255]),
                    'errors' => [
                        'name' => [
                            0 => __('validation.max.string', ['attribute' => 'name', 'max' => 255]),
                        ],
                    ],
                ]);
        });

    });

});
