<?php

use App\Domain\CashFlow\Process\DeleteCashFlowProcess;
use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: DestroyCashFlowController', function () {

    describe('Positives', function () {

        it('can hard delete a cash flow resource when using /api/v1/cash_flows/{cash_flow}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->deleteJson(sprintf('/api/v1/cash_flows/%s/destroy', $cash_flow->id));

            // Assert:
            $this->assertModelMissing($cash_flow);
            $this->assertDatabaseMissing($cash_flow);

            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'message' => __('messages.success.destroyed', ['record' => 'Cash flow']),
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/cash_flows/{cash_flow}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->deleteJson(sprintf('/api/v1/cash_flows/%s/destroy', $cash_flow->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/cash_flows/{cash_flow}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->deleteJson(sprintf('/api/v1/cash_flows/%s/destroy', $other_cash_flow->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/cash_flows/{cash_flow}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->deleteJson(sprintf('/api/v1/cash_flows/%s/destroy', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\CashFlow] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/cash_flows/{cash_flow}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Expectation:
            $this->mock(DeleteCashFlowProcess::class, function (MockInterface $mock) {
                $mock->shouldReceive('run')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->deleteJson(sprintf('/api/v1/cash_flows/%s/destroy', $cash_flow->id));

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
