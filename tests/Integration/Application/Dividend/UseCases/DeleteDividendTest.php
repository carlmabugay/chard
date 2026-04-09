<?php

use App\Application\Dividend\UseCases\DeleteDividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

describe('Integration: DeleteDividend Use Case', function () {

    it('can hard delete dividend when using handle method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->create();

        $service = Mockery::mock(DividendService::class);

        $use_case = new DeleteDividend($service);

        // Expectation:
        $service->shouldReceive('delete')
            ->once()
            ->with($dividend)
            ->andReturn(true);

        // Act:
        $result = $use_case->handle($dividend);

        // Assert:
        expect($result)->toBeTrue();
    });

});
