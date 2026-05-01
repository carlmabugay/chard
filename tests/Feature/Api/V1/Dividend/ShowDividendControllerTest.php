<?php

use App\Models\Dividend as DividendModel;
use App\Models\User as UserModel;

describe('Feature: ShowDividendController', function () {

    describe('Positives', function () {

        it('can return a dividend resource when using /api/v1/dividends/{dividend} GET api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->getJson(sprintf('/api/v1/dividends/%s', $dividend->id));

            // Assert:
            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'data' => [
                        'id' => $dividend->id,
                        'symbol' => $dividend->symbol,
                        'amount' => $dividend->amount,
                        'recorded_at' => $dividend->recorded_at->format('F d, Y'),
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/dividends/{dividend} GET api endpoint.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->getJson(sprintf('/api/v1/dividends/%s', $dividend->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/dividends/{dividend} GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/dividends/%s', $other_dividend->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/dividends/{dividend} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $dividend = DividendModel::factory()->create();

            // Act:
            $response = $this->actingAs($dividend->portfolio->user)->getJson(sprintf('/api/v1/dividends/%s', $random_id));

            // Assert
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\Dividend] %s.', $random_id),
                ]);
        });

    });

});
