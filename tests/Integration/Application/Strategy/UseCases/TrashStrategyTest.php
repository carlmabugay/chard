<?php

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Application\Strategy\UseCases\TrashStrategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;

describe('Integration: TrashStrategy Use Case', function () {

    it('can soft delete strategy when using handle method.', function () {
        // Arrange:
        $strategy = StrategyModel::factory()->create();

        $dto = StrategyDTO::fromModel($strategy);

        $service = Mockery::mock(StrategyService::class);

        $use_case = new TrashStrategy($service);

        // Expectation:
        $service->shouldReceive('trash')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
