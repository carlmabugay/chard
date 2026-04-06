<?php

use App\Domain\TradeLog\Entities\TradeLog;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentTradeLogWriteRepository;
use App\Models\Portfolio as PortfolioModel;
use App\Models\TradeLog as TradeLogModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentTradeLogWriteRepository;
});

describe('Integration: EloquentTradeLogWriteRepository', function () {

    describe('Positives', function () {

        it('can create new trade log when using store method.', function () {
            // Arrange
            $table = 'trade_logs';
            $portfolio = PortfolioModel::factory()->create();

            $trade_log = new TradeLog(
                portfolio_id: $portfolio->id,
                symbol: 'BPI',
                type: 'buy',
                price: 100,
                shares: 1000,
                fees: 120,
            );

            // Act:
            $result = $this->repository->store($trade_log);

            // Assert:
            expect($result)->toBeInstanceOf(TradeLog::class);

            $this->assertDatabaseCount($table, 1);
            $this->assertDatabaseHas($table, [
                'portfolio_id' => $trade_log->portfolioId(),
                'type' => $trade_log->type(),
                'symbol' => $trade_log->symbol(),
                'price' => $trade_log->price(),
                'shares' => $trade_log->shares(),
                'fees' => $trade_log->fees(),
            ]);

        });

        it('can update trade log when using store method.', function () {
            // Arrange:
            $trade_log_model = TradeLogModel::factory()->create();

            $trade_log_entity = new TradeLog(
                portfolio_id: $trade_log_model->portfolio->id,
                symbol: $trade_log_model->symbol,
                type: 'buy',
                price: $trade_log_model->price,
                shares: 5000,
                fees: $trade_log_model->fees,
            );

            // Act:
            $result = $this->repository->store($trade_log_entity);

            // Assert:
            expect($result)->toBeInstanceOf(TradeLog::class);

            $this->assertDatabaseHas('trade_logs', [
                'portfolio_id' => $trade_log_entity->portfolioId(),
                'type' => $trade_log_entity->type(),
                'symbol' => $trade_log_entity->symbol(),
                'price' => $trade_log_entity->price(),
                'shares' => $trade_log_entity->shares(),
                'fees' => $trade_log_entity->fees(),
                'id' => $result->id(),
            ]);
        });

        it('can soft delete trade log when using trash method.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $this->repository->trash($trade_log->id);

            // Assert
            $this->assertSoftDeleted($trade_log);
        });

        it('can restore trashed trade log when using restore method.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->trashed()->create();

            // Act:
            $this->repository->restore($trade_log->id);

            // Assert:
            $this->assertNotSoftDeleted($trade_log);
        });

        it('can hard delete trade log when using delete method.', function () {
            // Arrange:
            $trade_log = TradeLogModel::factory()->create();

            // Act:
            $this->repository->delete($trade_log->id);

            // Assert:
            $this->assertModelMissing($trade_log);
            $this->assertDatabaseMissing($trade_log);
        });

    });

    describe('Negatives', function () {

        it('can throw an exception when no record found upon using trash method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->trash($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

        it('can throw an exception when no record found upon using restore method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->restore($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

        it('can throw an exception when no record found upon using delete method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->delete($random_id);

            // Assert:
        })->throws(ModelNotFoundException::class);

    });
});
