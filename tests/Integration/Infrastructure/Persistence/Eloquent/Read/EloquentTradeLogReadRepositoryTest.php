<?php

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentTradeLogReadRepository;
use App\Models\TradeLog as TradeLogModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentTradeLogReadRepository;
});

describe('Integration: EloquentTradeLogReadRepository', function () {

    describe('Positives', function () {

        it('can return a trade log when using findById method.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $result = $this->repository->findById($trade_log->id);

            // Assert:
            expect($result)
                ->toBeInstanceOf(TradeLog::class)
                ->and($result->id())->toBe($trade_log->id);
        });

    });

    describe('Negatives', function () {

        it('can return an empty array when no records found upon using findAll method.', function () {
            // Act:
            $result = $this->repository->findAll(new QueryCriteria);

            // Assert:
            expect($result['data'])->toBeEmpty();
        });

        it('can throw an exception when no record found upon using findById method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->findById($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

    });

});
