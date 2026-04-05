<?php

use App\Application\CashFlow\UserCases\RestoreCashFlow;
use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: RestoreCashFlowController', function () {

    describe('Positives', function () {

        it('can restore trashed cash flow resource when using /api/v1/cash-flows PATCH api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();
            Sanctum::actingAs($cash_flow->portfolio->user);

            // Act:
            $response = $this->patch(sprintf('/api/v1/cash-flows/%s', $cash_flow->id));

            // Assert:
            $this->assertNotSoftDeleted($cash_flow);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });

    });

    describe('Negatives', function () {

        it('can handle error message when no record found upon using /api/v1/cash-flows/{id} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();
            Sanctum::actingAs($cash_flow->portfolio->user);

            // Act:
            $response = $this->patch(sprintf('/api/v1/cash-flows/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Cash flow not found.',
                    'message' => sprintf('Cash flow with ID: [%s] not found.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/cash-flows/{id} PATCH api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            // Expectation:
            $this->mock(RestoreCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->patch(sprintf('/api/v1/cash-flows/%s', $random_id));

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
