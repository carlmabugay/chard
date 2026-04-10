<?php

use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Enums\CashFlowType;
use App\Models\Portfolio as PortfolioModel;
use Mockery\MockInterface;

describe('Feature: StoreCashFlowController', function () {

    describe('Positives', function () {

        it('can store new cash flow resource when using /api/v1/cash_flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 100,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertCreated()
                ->assertJson([
                    'success' => true,
                    'message' => __('messages.success.stored', ['record' => 'Cash flow']),
                    'data' => [
                        'type' => $payload['type'],
                        'amount' => $payload['amount'],
                        'portfolio' => [
                            'id' => $payload['portfolio_id'],
                        ],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthorized message when trying to access protected /api/v1/cash_flows POST api endpoint unauthenticated.', function () {
            // Arrange:
            $payload = [
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 100,
            ];

            // Act:
            $response = $this->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertJson([
                    'message' => 'Unauthenticated.',
                ]);
        });

        it('can handle server error response when using /api/v1/cash_flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 100,
            ];

            // Expectation:
            $this->mock(StoreCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/cash_flows', $payload);

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
