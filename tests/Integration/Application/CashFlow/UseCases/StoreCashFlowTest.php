<?php

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: Store Cash Flow', function () {

    it('should store cash flow when using handle method.', function () {

        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $dto = StoreCashFlowDTO::fromArray([
            'portfolio_id' => $portfolio->id,
            'type' => 'deposit',
            'amount' => 5000,
        ]);

        $cash_flow_entity = new CashFlow(
            portfolio_id: $dto->portfolio_id,
            type: $dto->type,
            amount: $dto->amount,
        );

        $service = Mockery::mock(CashFlowService::class);

        // Expectation:
        $service->shouldReceive('store')
            ->once()
            ->andReturn($cash_flow_entity);

        // Act:
        $use_case = new StoreCashFlow($service);
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeInstanceOf(CashFlow::class);
    });
});
