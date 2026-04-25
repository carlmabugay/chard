<?php

use App\Domain\Portfolio\Processes\ListPortfoliosProcess;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: ListPortfolioController', function () {

    describe('Positives', function () {

        it('can return collection of portfolio resource when using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $no_of_portfolios = 5;
            $user = UserModel::factory()->create();

            PortfolioModel::factory($no_of_portfolios)->for($user)->create();

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/portfolios');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'meta' => [
                        'total' => $no_of_portfolios,
                    ],
                ]);
        });

        it('can return empty data and 0 total record when no records found upon using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/portfolios');

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'data' => [],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:

            // Act:
            $response = $this->getJson('/api/v1/portfolios');

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can handle server error response when using /api/v1/portfolios GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(ListPortfoliosProcess::class, function (MockInterface $mock) {
                $mock->shouldReceive('run')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->getJson('/api/v1/portfolios');

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
