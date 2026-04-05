<?php

use App\Application\Strategy\UseCases\RestoreStrategy;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;

describe('Integration: RestoreStrategy Use Case', function () {

    it('can restore trashed strategy when using handle method.', function () {
        // Arrange:
        $strategy = StrategyModel::factory()->create();

        $service = Mockery::mock(StrategyService::class);

        $use_case = new RestoreStrategy($service);

        // Expectation:
        $service->shouldReceive('restore')
            ->once()
            ->with($strategy->id)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($strategy->id);

        // Assert:
        expect($result)->toBeTrue();
    });

});
