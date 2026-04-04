<?php

use App\Application\Strategy\UseCases\TrashStrategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;

describe('Integration: TrashStrategy Use Case', function () {

    it('should soft delete strategy when using handle method.', function () {

        // Arrange:
        $strategy = StrategyModel::factory()->create();

        $service = Mockery::mock(StrategyService::class);

        // Expectation:
        $service->shouldReceive('trash')
            ->once()
            ->with($strategy->id)
            ->andReturn(true);

        $use_case = new TrashStrategy($service);

        // Act:
        $result = $use_case->handle($strategy->id);

        // Assert:
        expect($result)->toBeTrue();

    });

});
