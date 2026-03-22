<?php

use App\Application\Dividend\UseCases\ListDividends;
use App\Domain\Dividend\Entities\Dividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

describe('Integration: ListDividends Use Case', function () {

    it('should list all dividends when using handle method.', function () {

        // Arrange:
        $no_of_dividends = 10;
        $dividend_model = DividendModel::factory()->count($no_of_dividends)->create();
        $dividend_entity = $dividend_model->map(fn (DividendModel $model) => Dividend::fromEloquentModel($model))->all();

        $service = Mockery::mock(DividendService::class);

        $use_case = new ListDividends($service);

        $service->shouldReceive('findAll')
            ->once()
            ->andReturn([
                $dividend_entity,
            ]);

        // Act:
        $result = $use_case->handle();

        // Assert:
        expect($result)
            ->toBeArray()
            ->and(count($dividend_entity))->toEqual($no_of_dividends);

    });
});
