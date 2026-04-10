<?php

use App\Application\Dividend\UseCases\RestoreDividend;
use App\Models\Dividend as DividendModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: RestoreDividendController', function () {

    describe('Positives', function () {

        it('can restore trashed dividend resource when using /api/v1/dividends PATCH api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->trashed()->create();

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->patchJson(sprintf('/api/v1/dividends/%s', $dividend->id));

            // Assert:
            $this->assertNotSoftDeleted($dividend);

            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'message' => __('messages.success.restored', ['record' => 'Dividend']),
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/dividends PATCH api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->trashed()->create();

            // Act:
            $response = $this->patchJson(sprintf('/api/v1/dividends/%s', $dividend->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/dividends PATCH api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->patchJson(sprintf('/api/v1/dividends/%s', $other_dividend->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/dividends/{dividend} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $dividend = DividendModel::factory()->trashed()->create();

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->patchJson(sprintf('/api/v1/dividends/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Dividend] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/dividends/{dividend} PATCH api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->trashed()->create();

            // Expectation:
            $this->mock(RestoreDividend::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->patchJson(sprintf('/api/v1/dividends/%s', $dividend->id));

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
