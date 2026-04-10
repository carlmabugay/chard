<?php

use App\Application\Dividend\UseCases\TrashDividend;
use App\Models\Dividend as DividendModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: TrashDividendController', function () {

    describe('Positives', function () {

        it('can trash existing cash flow resource when using /api/v1/dividends/{dividend}/trash DELETE api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->deleteJson(sprintf('/api/v1/dividends/%s/trash', $dividend->id));

            // Assert:
            $this->assertSoftDeleted($dividend);

            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'message' => __('messages.success.trashed', ['record' => 'Dividend']),
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/dividends/{dividend}/trash DELETE api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->deleteJson(sprintf('/api/v1/dividends/%s/trash', $dividend->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/dividends/{dividend}/trash DELETE api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->deleteJson(sprintf('/api/v1/dividends/%s/trash', $other_dividend->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthorized.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/dividends/{dividend}/trash DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->deleteJson(sprintf('/api/v1/dividends/%s/trash', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Dividend] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/dividends/{dividend}/trash DELETE api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Expectation:
            $this->mock(TrashDividend::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->deleteJson(sprintf('/api/v1/dividends/%s/trash', $dividend->id));

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
