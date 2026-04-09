<?php

use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Models\CashFlow as CashFlowModel;
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

        it('can return unauthorized message when trying to access protected /api/v1/cash_flows/{cash_flow} PUT api endpoint unauthenticated.', function () {
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
