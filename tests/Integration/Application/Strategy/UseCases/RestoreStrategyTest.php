<?php

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Application\Strategy\UseCases\RestoreStrategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;

describe('Integration: DeleteStrategy Use Case', function () {

    it('can restore trashed strategy when using handle method.', function () {
        // Arrange:
        $strategy = StrategyModel::factory()->create();

        $dto = StrategyDTO::fromModel($strategy);

        $service = Mockery::mock(StrategyService::class);

        $use_case = new RestoreStrategy($service);

        // Expectation:
        $service->shouldReceive('restore')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
