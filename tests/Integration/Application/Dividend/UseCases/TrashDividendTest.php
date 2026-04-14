<?php

use App\Application\Dividend\DTOs\DividendDTO;
use App\Application\Dividend\UseCases\TrashDividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

describe('Integration: TrashDividend Use Case', function () {

    it('can soft delete dividend when using handle method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->create();

        $dto = DividendDTO::fromModel($dividend);

        $service = Mockery::mock(DividendService::class);

        $use_case = new TrashDividend($service);

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
