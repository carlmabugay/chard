<?php

use App\Application\Dividend\UseCases\GetDividend;
use App\Domain\Dividend\Entities\Dividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

describe('Integration: GetDividend Use Case', function () {

    it('should return dividend that filtered by id when using handle method.', function () {

        // Arrange:
        $dividend_model = DividendModel::factory()->create();

        $dividend_entity = Dividend::fromEloquentModel($dividend_model);

        $service = Mockery::mock(DividendService::class);

        $use_case = new GetDividend($service);

        // Expectation:
        $service->shouldReceive('findById')
            ->once()
            ->with($dividend_model->id)
            ->andReturn($dividend_entity);

        // Act:
        $result = $use_case->handle($dividend_model->id);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Dividend::class)
            ->and($result->id())->toBe($dividend_entity->id());

    });

});
