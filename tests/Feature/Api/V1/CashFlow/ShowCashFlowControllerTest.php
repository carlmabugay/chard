<?php

use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;

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
                        'created_at' => $cash_flow->created_at->format('F d, Y'),
                        'updated_at' => $cash_flow->updated_at->format('F d, Y'),
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
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
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
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
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

    });

});
