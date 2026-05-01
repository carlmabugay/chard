<?php

use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentDividendReadRepository;
use App\Models\Dividend as DividendModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentDividendReadRepository;
});

describe('Integration: EloquentDividendReadRepository', function () {

    describe('Positives', function () {

        it('can return a cash flows when using findById method.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $result = $this->repository->findById($dividend->id);

            // Assert:
            expect($result)
                ->toBeInstanceOf(Dividend::class)
                ->and($result->id())->toBe($dividend->id);
        });

    });

    describe('Negatives', function () {

        it('can throw an exception when no record found upon using findById method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->findById($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

    });

});
