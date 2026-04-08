<?php

use App\Application\Dividend\UseCases\DeleteDividend;
use App\Models\Dividend as DividendModel;
use App\Models\User as UserModel;
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
                    'error' => 'Dividend not found.',
                    'message' => sprintf('Dividend with ID: [%s] not found.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/dividends/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(DeleteDividend::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->deleteJson(sprintf('/api/v1/dividends/%s/destroy', $random_id));

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
