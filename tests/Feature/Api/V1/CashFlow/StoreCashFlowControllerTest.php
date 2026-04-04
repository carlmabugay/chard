<?php

use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Enums\CashFlowType;
use App\Models\Portfolio as PortfolioModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: StoreCashFlowController', function () {

    describe('Positives', function () {

        it('can store new cash flow resource when using /api/v1/cash-flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

            $payload = [
                'portfolio_id' => $portfolio->id,
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 100,
            ];

            // Act:
            $response = $this->post('/api/v1/cash-flows', $payload);

            // Assert:
            $response->assertCreated()
                ->assertJson([
                    'success' => true,
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

        it('can handle server error response when using /api/v1/cash-flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            Sanctum::actingAs($portfolio->user);

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
            $response = $this->post('/api/v1/cash-flows', $payload);

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
