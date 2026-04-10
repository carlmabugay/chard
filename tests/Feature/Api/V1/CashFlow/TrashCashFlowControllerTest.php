<?php

use App\Application\CashFlow\UserCases\TrashCashFlow;
use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: TrashCashFlowController', function () {

    describe('Positives', function () {

        it('can trash existing cash flow resource when using /api/v1/cash_flows/{cash_flow}/trash DELETE api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->deleteJson(sprintf('/api/v1/cash_flows/%s/trash', $cash_flow->id));

            // Assert:
            $this->assertSoftDeleted($cash_flow);

            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'message' => __('messages.success.trashed', ['record' => 'Cash flow']),
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/cash_flows/{cash_flow}/trash DELETE api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->deleteJson(sprintf('/api/v1/cash_flows/%s/trash', $cash_flow->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/cash_flows/{cash_flow}/trash DELETE api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->deleteJson(sprintf('/api/v1/cash_flows/%s/trash', $other_cash_flow->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthorized.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/cash_flows/{cash_flow}/trash DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->deleteJson(sprintf('/api/v1/cash_flows/%s/trash', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\CashFlow] %s.', $random_id),
                ]);

        });

        it('can handle server error response when using /api/v1/cash_flows/{cash_flow}/trash DELETE api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Expectation:
            $this->mock(TrashCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->deleteJson(sprintf('/api/v1/cash_flows/%s/trash', $cash_flow->id));

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
