<?php

use App\Application\Dividend\UseCases\StoreDividend;
use App\Models\Dividend as DividendModel;
use Mockery\MockInterface;

describe('Feature: UpdateDividendController', function () {

    describe('Positives', function () {

        it('can update existing cash flow resource when using /api/v1/dividends/{dividend} PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 1000,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson(sprintf('/api/v1/dividends/%s', $dividend->id), $payload);

            // Assert:
            $this->assertDatabaseHas('dividends', $payload);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'amount' => $payload['amount'],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/dividends/{dividend} PUT api endpoint unauthenticated.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 1000,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->putJson(sprintf('/api/v1/cash_flows/%s', $dividend->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/dividends PUT api endpoint unauthenticated.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 1000,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->putJson(sprintf('/api/v1/dividends/%s', $dividend->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/portfolios/{portfolio} PUT api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 1000,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson(sprintf('/api/v1/dividends/%s', $random_id), $payload);

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Dividend] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/dividends/{dividend} PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 1000,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Expectation:
            $this->mock(StoreDividend::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson(sprintf('/api/v1/dividends/%s', $dividend->id), $payload);

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
