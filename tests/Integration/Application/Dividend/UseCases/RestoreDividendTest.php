<?php

use App\Application\Dividend\UseCases\RestoreDividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

describe('Integration: RestoreDividend Use Case', function () {

    it('can restore trashed dividend when using handle method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->trashed()->create();

        $service = Mockery::mock(DividendService::class);

        $use_case = new RestoreDividend($service);

        // Expectation:
        $service->shouldReceive('restore')
            ->once()
            ->with($dividend)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dividend);

        // Assert
        expect($result)->toBeTrue();
    });
});
