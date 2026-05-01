<?php

use App\Domain\Dividend\Process\UpdateDividendProcess;
use App\Models\Dividend as DividendModel;
use App\Models\User as UserModel;
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
                    'message' => __('messages.success.updated', ['record' => 'Dividend']),
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/dividends/{dividend} PUT api endpoint.', function () {
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
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/dividends/{dividend} PUT api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $other_dividend->portfolio->id,
                'symbol' => $other_dividend->symbol,
                'amount' => 1000,
                'recorded_at' => $other_dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->actingAs($user)->putJson(sprintf('/api/v1/dividends/%s', $other_dividend->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/dividends/{dividend} PUT api endpoint.', function () {
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
            $this->mock(UpdateDividendProcess::class, function (MockInterface $mock) {
                $mock->shouldReceive('run')
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

    describe('Validations', function () {

        it('requires symbol, amount, and recorded_at fields when using /api/v1/dividends/{dividend} PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [];

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson(sprintf('/api/v1/dividends/%s', $dividend->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'symbol' => [__('validation.required', ['attribute' => 'symbol'])],
                        'amount' => [__('validation.required', ['attribute' => 'amount'])],
                        'recorded_at' => [__('validation.required', ['attribute' => 'recorded at'])],
                    ],
                ]);
        });

        it('requires portfolio id field to exits when using /api/v1/dividends/{dividend} PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => 100,
                'symbol' => $dividend->symbol,
                'amount' => $dividend->amount,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson(sprintf('/api/v1/dividends/%s', $dividend->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'portfolio_id' => [__('validation.exists', ['attribute' => 'portfolio id'])],
                    ],
                ]);
        });

        it('requires amount field to be numeric when using /api/v1/dividends/{dividend} PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 'not-an-integer',
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson(sprintf('/api/v1/dividends/%s', $dividend->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'amount' => [__('validation.numeric', ['attribute' => 'amount'])],
                    ],
                ]);
        });

        it('requires amount field to be at least 1 when using /api/v1/dividends/{dividend} PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => 0,
                'recorded_at' => $dividend->recorded_at->toDateTimeString(),
            ];

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson(sprintf('/api/v1/dividends/%s', $dividend->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'amount' => [__('validation.min.numeric', ['attribute' => 'amount', 'min' => 1])],
                    ],
                ]);
        });

        it('requires recorded at field to be valid date format when using /api/v1/dividends/{dividend} PUT api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            $payload = [
                'portfolio_id' => $dividend->portfolio->id,
                'symbol' => $dividend->symbol,
                'amount' => $dividend->amount,
                'recorded_at' => 'not-a-date',
            ];

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->putJson(sprintf('/api/v1/dividends/%s', $dividend->id), $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'recorded_at' => [
                            __('validation.date', ['attribute' => 'recorded at']),
                            __('validation.date_format', ['attribute' => 'recorded at', 'format' => 'Y-m-d H:i:s']),
                        ],
                    ],
                ]);
        });

    });

});
