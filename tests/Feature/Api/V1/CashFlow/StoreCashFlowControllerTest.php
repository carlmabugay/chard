<?php

use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Models\Portfolio as PortfolioModel;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;

describe('Feature: StoreCashFlowController', function () {

    describe('Positives', function () {

        it('should store new cash flow resource when using /api/v1/cashflows POST api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'type' => 'deposit',
                'amount' => 100,
            ];

            // Act:
            Sanctum::actingAs($portfolio->user);
            $response = $this->post('/api/v1/cashflows', $payload);

            // Assert:
            $response->assertCreated()
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'portfolio_id' => $payload['portfolio_id'],
                        'type' => $payload['type'],
                        'amount' => $payload['amount'],
                    ],
                ]);
        });

    });

    describe('Negatives', function () {

        it('should handle server error response when using /api/v1/cashflows POST api endpoint.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'type' => 'deposit',
                'amount' => 100,
            ];

            // Expectation:
            $this->mock(StoreCashFlow::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            Sanctum::actingAs($portfolio->user);
            $response = $this->post('/api/v1/cashflows', $payload);

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
