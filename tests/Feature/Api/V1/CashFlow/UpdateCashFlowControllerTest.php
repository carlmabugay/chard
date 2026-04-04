<?php

use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Models\CashFlow as CashFlowModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: UpdateCashFlowController', function () {

    describe('Positives', function () {

        it('can update existing cash flow resource when using /api/v1/cash-flows PUT api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();
            Sanctum::actingAs($cash_flow->portfolio->user);

            $payload = [
                'portfolio_id' => $cash_flow->portfolio->id,
                'type' => $cash_flow->type->value,
                'amount' => 1000,
                'id' => $cash_flow->id,
            ];

            // Act:
            $response = $this->put('/api/v1/cash-flows', $payload);

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

        it('can handle server error response when using /api/v1/cash-flows PUT api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();
            Sanctum::actingAs($cash_flow->portfolio->user);

            $payload = [
                'portfolio_id' => $cash_flow->portfolio->id,
                'type' => $cash_flow->type->value,
                'amount' => 1000,
                'id' => $cash_flow->id,
            ];

            // Expectation:
            $this->mock(StoreCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->put('/api/v1/cash-flows', $payload);

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
