<?php

use App\Application\Portolio\UseCases\StorePortfolio;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: StorePortfolioController', function () {

    describe('Positives', function () {

        it('can store new portfolio resource when using /api/v1/portfolios POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            $payload = [
                'user_id' => $user->id,
                'name' => 'PH Stock Market',
            ];

            // Act:
            $response = $this->post('/api/v1/portfolios', $payload);

            // Assert:
            $response->assertCreated()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'name' => $payload['name'],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can handle server error response when using /api/v1/portfolios POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            $payload = [
                'user_id' => $user->id,
                'name' => 'PH Stock Market',
            ];

            // Expectation:
            $this->mock(StorePortfolio::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->post('/api/v1/portfolios', $payload);

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
