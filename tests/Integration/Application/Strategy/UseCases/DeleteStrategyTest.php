<?php

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Application\Strategy\UseCases\DeleteStrategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;

describe('Integration: DeleteStrategy Use Case', function () {

    it('can hard delete strategy when using handle method.', function () {
        // Arrange:
        $strategy = StrategyModel::factory()->create();

        $dto = StrategyDTO::fromModel($strategy);

        $service = Mockery::mock(StrategyService::class);

        $use_case = new DeleteStrategy($service);

        // Expectation:
        $service->shouldReceive('delete')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeTrue();
    });

});
