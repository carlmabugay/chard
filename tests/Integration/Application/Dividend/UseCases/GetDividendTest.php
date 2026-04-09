<?php

use App\Application\Dividend\UseCases\GetDividend;
use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

describe('Integration: GetDividend Use Case', function () {

    it('can return dividend that filtered by id when using handle method.', function () {

        // Arrange:
        $dividend_model = DividendModel::factory()->create();

        $dividend_entity = Dividend::fromEloquentModel($dividend_model);

        $use_case = new GetDividend;

        // Act:
        $result = $use_case->handle($dividend_model);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Dividend::class)
            ->and($result->id())->toBe($dividend_entity->id());

    });

});
