<?php

use App\Application\Dividend\UseCases\ListDividends;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Entities\Dividend;
use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

describe('Integration: ListDividends Use Case', function () {

    it('can list all dividends when using handle method.', function () {

        // Arrange:
        $no_of_dividends = 10;
        $dividend_model = DividendModel::factory($no_of_dividends)->create();
        $dividend_entity = $dividend_model->map(fn (DividendModel $model) => Dividend::fromEloquentModel($model))->all();

        $service = Mockery::mock(DividendService::class);
        $criteria = Mockery::mock(QueryCriteria::class);

        $use_case = new ListDividends($service);

        // Expectation:
        $service->shouldReceive('findAll')
            ->once()
            ->with($criteria)
            ->andReturn([
                $dividend_entity,
            ]);

        // Act:
        $result = $use_case->handle($criteria);

        // Assert:
        expect($result)
            ->toBeArray()
            ->and(count($dividend_entity))->toEqual($no_of_dividends);

    });

});
