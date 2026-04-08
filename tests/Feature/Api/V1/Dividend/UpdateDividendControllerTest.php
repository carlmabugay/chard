<?php

use App\Application\Dividend\UseCases\StoreDividend;
use App\Models\Dividend as DividendModel;
use Mockery\MockInterface;

describe('Feature: UpdateDividendController', function () {

    describe('Positives', function () {

        it('can update existing cash flow resource when using /api/v1/dividends PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 1000,
                'id' => $dividend->id,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson('/api/v1/dividends', $payload);

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

        it('can handle server error response when using /api/v1/dividends PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 1000,
                'id' => $dividend->id,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Expectation:
            $this->mock(StoreDividend::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson('/api/v1/dividends', $payload);

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
