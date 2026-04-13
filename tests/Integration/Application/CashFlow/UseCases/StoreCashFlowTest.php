<?php

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Enums\CashFlowType;
use App\Models\Portfolio as PortfolioModel;

describe('Integration: StoreCashFlow Use Case', function () {

    it('can store cash flow when using handle method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $dto = new CashFlowDTO(
            portfolio_id: $portfolio->id,
            type: CashFlowType::DEPOSIT,
            amount: 500,
        );

        $cash_flow_entity = CashFlow::fromDTO($dto);

        $service = Mockery::mock(CashFlowService::class);

        $use_case = new StoreCashFlow($service);

        // Expectation:
        $service->shouldReceive('store')
            ->once()
            ->andReturn($cash_flow_entity);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)
            ->toBeInstanceOf(CashFlow::class)
            ->and($result->portfolioId())->toBe($dto->portfolioId())
            ->and($result->type())->toBe($dto->type())
            ->and($result->amount())->toBe($dto->amount());
    });

});
