<?php

use App\Application\Dividend\DTOs\DividendDTO;
use App\Application\Dividend\UseCases\DeleteDividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

describe('Integration: DeleteDividend Use Case', function () {

    it('can hard delete dividend when using handle method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->create();

        $dto = DividendDTO::fromModel($dividend);

        $service = Mockery::mock(DividendService::class);

        $use_case = new DeleteDividend($service);

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
