<?php

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: ShowCashFlowController', function () {

    describe('Positives', function () {

        it('can return a cash flow resource when using /api/v1/cash_flows/{cash_flow} GET api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->getJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id));

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

        it('can return unauthenticated message when trying to access protected /api/v1/cash_flows/{cash_flow} GET api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->getJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/cash_flows/{cash_flow} GET api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();
            $other_cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($user)->getJson(sprintf('/api/v1/cash_flows/%s', $other_cash_flow->id));

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthorized.',
                ]);
        });

        it('can handle error message when no record found upon using /api/v1/cash_flows/{cash_flow} GET api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->getJson(sprintf('/api/v1/cash_flows/%s', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Record not found.',
                    'message' => sprintf('No query results for model [App\\Models\\CashFlow] %s.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/cash_flows/{cash_flow} GET api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();

            // Expectation:
            $this->mock(GetCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($cash_flow->portfolio->user)->getJson(sprintf('/api/v1/cash_flows/%s', $cash_flow->id));

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
