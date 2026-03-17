<?php

use App\Application\UseCases\ListStrategies;
use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: List of all Strategies', function () {

    it('should list all strategies when using handle method.', function () {

        // Arrange:
        $count = 10;
        $strategies = StrategyModel::factory()->count($count)->create();

        $service = Mockery::mock(StrategyService::class);

        $use_case = new ListStrategies($service);

        $service->shouldReceive('fetchAll')
            ->once()
            ->andReturn([
                $strategies,
            ]);

        // Act:
        $result = $use_case->handle();

        // Assert:
        expect($result[0])
            ->toHaveCount($count);

    });
});
