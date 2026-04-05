<?php

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ShowCashFlowController', function () {

    describe('Positives', function () {

        it('can return a cash flow resource when using /api/v1/cash-flows/{id} GET api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();
            Sanctum::actingAs($cash_flow->portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/cash-flows/%s', $cash_flow->id));

            // Assert:
            $response->assertOk()
                ->assertExactJson([
                    'success' => true,
                    'data' => [
                        'id' => $cash_flow->id,
                        'type' => $cash_flow->type,
                        'amount' => $cash_flow->amount,
                        'created_at' => $cash_flow->created_at->toDateTimeString(),
                        'updated_at' => $cash_flow->updated_at->toDateTimeString(),
                        'portfolio' => [
                            'id' => $cash_flow->portfolio->id,
                            'name' => $cash_flow->portfolio->name,
                            'created_at' => $cash_flow->portfolio->created_at->toDateTimeString(),
                            'updated_at' => $cash_flow->portfolio->updated_at->toDateTimeString(),
                        ],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can handle error message when no record found upon using /api/v1/cash-flows/{id} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();
            Sanctum::actingAs($cash_flow->portfolio->user);

            // Act:
            $response = $this->get(sprintf('/api/v1/cash-flows/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Cash flow not found.',
                    'message' => sprintf('Cash flow with ID: [%s] not found.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/cash-flows/{id} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            // Expectation:
            $this->mock(GetCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->get(sprintf('/api/v1/cash-flows/%s', $random_id));

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
