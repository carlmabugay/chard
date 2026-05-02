<?php

use App\Domain\CashFlow\Process\StoreCashFlowProcess;
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
                ]);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/cash_flows POST api endpoint.', function () {
            // Arrange:
            $payload = [
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 100,
            ];

            // Act:
            $response = $this->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can return unauthorized message when trying to access protected /api/v1/cash_flows POST api endpoint', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();
            $other_portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $other_portfolio->id,
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 100,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthorized'),
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
            $this->mock(StoreCashFlowProcess::class, function (MockInterface $mock) {
                $mock->shouldReceive('run')
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

    describe('Validations', function () {

        it('requires portfolio id, type and amount fields when using /api/v1/cash_flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'portfolio_id' => [__('validation.required', ['attribute' => 'portfolio id'])],
                        'type' => [__('validation.required', ['attribute' => 'type'])],
                        'amount' => [__('validation.required', ['attribute' => 'amount'])],
                    ],
                ]);
        });

        it('requires portfolio id field to exists when using /api/v1/cash_flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => 100,
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 2000,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'portfolio_id' => [__('validation.exists', ['attribute' => 'portfolio id'])],
                    ],
                ]);
        });

        it('requires valid type field when using /api/v1/cash_flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'type' => 'not-cash-flow-type',
                'amount' => 2000,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'type' => [__('validation.enum', ['attribute' => 'type'])],
                    ],
                ]);
        });

        it('requires amount field to be numeric when using /api/v1/cash_flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 'not-cash-flow-amount',
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'amount' => [__('validation.numeric', ['attribute' => 'amount'])],
                    ],
                ]);
        });

        it('requires amount field to be at least 1 when using /api/v1/cash_flows POST api endpoint.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            $payload = [
                'portfolio_id' => $portfolio->id,
                'type' => CashFlowType::DEPOSIT->value,
                'amount' => 0,
            ];

            // Act:
            $response = $this->actingAs($portfolio->user)->postJson('/api/v1/cash_flows', $payload);

            // Assert:
            $response->assertUnprocessable()
                ->assertJson([
                    'errors' => [
                        'amount' => [__('validation.min.numeric', ['attribute' => 'amount', 'min' => 1])],
                    ],
                ]);
        });

    });

});
