<?php

use App\Application\CashFlow\UserCases\RestoreCashFlow;
use App\Models\CashFlow as CashFlowModel;
use Mockery\MockInterface;

describe('Feature: RestoreCashFlowController', function () {

    describe('Positives', function () {

        it('can restore trashed cash flow resource when using /api/v1/cash_flows PATCH api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->patchJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id));

            // Assert:
            $this->assertNotSoftDeleted($cash_flow);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected  /api/v1/cash_flows PATCH api endpoint unauthenticated.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->patchJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/cash_flows/{cash_flow} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->patchJson(sprintf('/api/v1/cash_flows/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\CashFlow] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/cash_flows/{cash_flow} PATCH api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Expectation:
            $this->mock(RestoreCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->patchJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id));

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
