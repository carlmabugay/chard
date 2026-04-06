<?php

use App\Application\CashFlow\UserCases\DeleteCashFlow;
use App\Models\CashFlow as CashFlowModel;
use App\Models\User as UserModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: DestroyCashFlowController', function () {

    describe('Positives', function () {

        it('can hard delete a cash flow resource when using /api/v1/cash-flows/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $cash_flow = CashFlowModel::factory()->create();
            Sanctum::actingAs($cash_flow->portfolio->user);

            // Act:
            $response = $this->delete(sprintf('/api/v1/cash-flows/%s/destroy', $cash_flow->id));

            // Assert:
            $this->assertModelMissing($cash_flow);
            $this->assertDatabaseMissing($cash_flow);

            $response->assertOk()
                ->assertJson([
                    'success' => true,
                ]);
        });
    });

    describe('Negatives', function () {

        it('can handle error message when no record found upon using /api/v1/cash-flows/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $cash_flow = CashFlowModel::factory()->create();
            Sanctum::actingAs($cash_flow->portfolio->user);

            // Act:
            $response = $this->delete(sprintf('/api/v1/cash-flows/%s/destroy', $random_id));

            // Assert:
            $response->assertNotFound()
                ->assertJson([
                    'success' => false,
                    'error' => 'Cash flow not found.',
                    'message' => sprintf('Cash flow with ID: [%s] not found.', $random_id),
                ]);
        });

        it('can handle server error response when using /api/v1/cash-flows/{id}/destroy DELETE api endpoint.', function () {
            // Arrange:
            $random_id = 100;
            $user = UserModel::factory()->create();
            Sanctum::actingAs($user);

            // Expectation:
            $this->mock(DeleteCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->delete(sprintf('/api/v1/cash-flows/%s/destroy', $random_id));

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
