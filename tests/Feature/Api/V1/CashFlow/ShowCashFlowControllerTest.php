<?php

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: ShowCashFlowController', function () {

    describe('Positives', function () {

        it('should return a cash flow resource when using /api/v1/cashflows/{id} GET api endpoint.', function () {

            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            Sanctum::actingAs($cash_flow->portfolio->user);
            $response = $this->get(sprintf('%s/%s', '/api/v1/cashflows', $cash_flow->id));

            // Assert:
            $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'portfolio_id' => $cash_flow->portfolio_id,
                        'id' => $cash_flow->id,
                        'type' => $cash_flow->type,
                        'amount' => $cash_flow->amount,
                        'created_at' => $cash_flow->created_at,
                        'updated_at' => $cash_flow->updated_at,
                    ],
                ]);

        });

    });

    describe('Negatives', function () {

        it('should handle error message when no record found upon using /api/v1/cashflows/{id} GET api endpoint.', function () {

            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            Sanctum::actingAs($cash_flow->portfolio->user);
            $response = $this->get(sprintf('/api/v1/cashflows/%s', $random_id));

            // Assert:

            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Cash flow not found',
                    'message' => sprintf('Cash flow with ID: %s not found', $random_id),
                ]);

        });

        it('should handle server error response when using /api/v1/cashflows/{id} GET api endpoint.', function () {

            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(GetCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($user);
            $response = $this->get(sprintf('/api/v1/cashflows/%s', $random_id));

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
