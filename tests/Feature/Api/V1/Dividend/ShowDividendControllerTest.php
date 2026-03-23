<?php

use App\Application\Dividend\UseCases\GetDividend;
use App\Models\Dividend as DividendModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ShowDividendController', function () {

    describe('Positives', function () {

        it('should return a dividend resource when using /api/v1/dividends/{id} GET api endpoint.', function () {

            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            Sanctum::actingAs($dividend->portfolio->user);
            $response = $this->get(sprintf('%s/%s', '/api/v1/dividends', $dividend->id));

            // Assert:
            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'data' => [
                        'portfolio_id' => $dividend->portfolio_id,
                        'id' => $dividend->id,
                        'symbol' => $dividend->symbol,
                        'amount' => $dividend->amount,
                        'recorded_at' => $dividend->recorded_at->toDateTimeString(),
                    ],
                ]);

        });

    });

    describe('Negatives', function () {

        it('should handle error message when no record found upon using /api/v1/dividends/{id} GET api endpoint.', function () {

            // Arrange:
            $random_id = 100;
            $dividend = DividendModel::factory()->create();

            // Act:
            Sanctum::actingAs($dividend->portfolio->user);
            $response = $this->get(sprintf('%s/%s', '/api/v1/dividends', $random_id));

            // Assert
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Dividend not found',
                    'message' => sprintf('Dividend with ID: %s not found', $random_id),
                ]);
        });

        it('should handle server error response when using /api/v1/dividends/{id} GET api endpoint.', function () {

            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(GetDividend::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get(sprintf('/api/v1/dividends/%s', $random_id));

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
