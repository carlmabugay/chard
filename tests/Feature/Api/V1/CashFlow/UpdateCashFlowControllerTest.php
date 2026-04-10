<?php

use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: UpdateCashFlowController', function () {

    describe('Positives', function () {

        it('can update existing cash flow resource when using /api/v1/cash_flows/{cash_flow} PUT api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            $payload = [
                'type' => $cash_flow->type->value,
                'amount' => 1000,
            ];

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->putJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id), $payload);

            // Assert:
            $this->assertDatabaseHas('cash_flows', $payload);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'amount' => $payload['amount'],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/cash_flows/{cash_flow} PUT api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            $payload = [
                'type' => $cash_flow->type->value,
                'amount' => 1000,
            ];

            // Act:
            $response = $this->putJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/cash_flows/{cash_flow} PUT api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_cash_flow = CashFlowModel::factory()->create();

            $payload = [
                'type' => $other_cash_flow->type->value,
                'amount' => 1000,
            ];

            // Act:
            $response = $this->actingAs($user)->putJson(sprintf('/api/v1/cash_flows/%s', $other_cash_flow->id), $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthorized.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/cash_flows/{cash_flow} PUT api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();

            $payload = [
                'type' => $cash_flow->type->value,
                'amount' => 1000,
            ];

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->putJson(sprintf('/api/v1/cash_flows/%s', $random_id), $payload);

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\CashFlow] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/cash_flows/{cash_flow} PUT api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            $payload = [
                'portfolio_id' => $cash_flow->portfolio->id,
                'type' => $cash_flow->type->value,
                'amount' => 1000,
            ];

            // Expectation:
            $this->mock(StoreCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->putJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id), $payload);

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
