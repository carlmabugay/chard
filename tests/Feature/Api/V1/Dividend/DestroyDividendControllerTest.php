<?php

use App\Application\Dividend\UseCases\DeleteDividend;
use App\Models\Dividend as DividendModel;
use Mockery\MockInterface;

describe('Feature: DestroyDividendController', function () {

    describe('Positives', function () {

        it('can hard delete dividend resource when using /api/v1/dividends/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->deleteJson(sprintf('/api/v1/dividends/%s/destroy', $dividend->id));

            // Assert:
            $this->assertModelMissing($dividend);
            $this->assertDatabaseMissing($dividend);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });
    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/dividends/{id}/destroy DELETE api endpoint unauthenticated.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->deleteJson(sprintf('/api/v1/dividends/%s/destroy', $dividend->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/dividends/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->deleteJson(sprintf('/api/v1/dividends/%s/destroy', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Dividend] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/dividends/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $dividend = DividendModel::factory()->create();

            // Expectation:
            $this->mock(DeleteDividend::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->deleteJson(sprintf('/api/v1/dividends/%s/destroy', $dividend->id));

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
