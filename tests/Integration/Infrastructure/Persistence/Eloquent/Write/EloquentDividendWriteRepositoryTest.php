<?php

use App\Application\Dividend\DTOs\DividendDTO;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Models\Dividend as DividendModel;

beforeEach(function () {
    $this->repository = new EloquentDividendWriteRepository;
});

describe('Integration: EloquentDividendWriteRepository', function () {

    it('can hard delete dividend when using delete method.', function () {
        // Arrange:
        $dividend = DividendModel::factory()->create();

        $dto = DividendDTO::fromModel($dividend);

        // Act:
        $this->repository->delete($dto);

        // Assert:
        $this->assertModelMissing($dividend);
        $this->assertDatabaseMissing($dividend);
    });

});
