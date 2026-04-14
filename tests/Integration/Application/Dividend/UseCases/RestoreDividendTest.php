<?php

use App\Application\Dividend\DTOs\DividendDTO;
use App\Application\Dividend\UseCases\RestoreDividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

describe('Integration: RestoreDividend Use Case', function () {

    it('can restore trashed dividend when using handle method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->trashed()->create();

        $dto = DividendDTO::fromModel($dividend);

        $service = Mockery::mock(DividendService::class);

        $use_case = new RestoreDividend($service);

        // Expectation:
        $service->shouldReceive('restore')
            ->once()
            ->with($dto)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dto);

        // Assert
        expect($result)->toBeTrue();
    });
});
