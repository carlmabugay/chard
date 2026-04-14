<?php

use App\Application\Dividend\DTOs\DividendDTO;
use App\Application\Dividend\UseCases\StoreDividend;
use App\Domain\Dividend\Entities\Dividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Portfolio;

describe('Integration: StoreDividend Use Case', function () {

    it('can store a dividend when using the handle method.', function () {

        // Arrange:
        $portfolio = Portfolio::factory()->create();

        $dto = new DividendDTO(
            portfolio_id: $portfolio->id,
            symbol: 'JFC',
            amount: 10000,
            recorded_at: now(),
        );

        $dividend_entity = Dividend::fromDTO($dto);

        $service = Mockery::mock(DividendService::class);

        $use_case = new StoreDividend($service);

        // Expectation:
        $service->shouldReceive('store')
            ->once()
            ->andReturn($dividend_entity);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Dividend::class)
            ->and($result->portfolioId())->toBe($dto->portfolioId())
            ->and($result->symbol())->toBe($dto->symbol())
            ->and($result->amount())->toBe($dto->amount())
            ->and($result->recordedAt())->toBe($dto->recordedAt());
    });

});
