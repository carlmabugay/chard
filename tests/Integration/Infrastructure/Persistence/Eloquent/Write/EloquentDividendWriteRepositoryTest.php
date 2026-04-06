<?php

use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Models\Dividend as DividendModel;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentDividendWriteRepository;
});

describe('Integration: EloquentDividendWriteRepository', function () {

    describe('Positives', function () {

        it('can create new dividend when using store method.', function () {
            // Arrange
            $table = 'dividends';
            $portfolio = PortfolioModel::factory()->create();

            $dividend_entity = new Dividend(
                portfolio_id: $portfolio->id,
                symbol: 'JFC',
                amount: 5000,
                recorded_at: now(),
            );

            // Act:
            $result = $this->repository->store($dividend_entity);

            // Assert:
            expect($result)->toBeInstanceOf(Dividend::class);

            $this->assertDatabaseCount($table, 1);
            $this->assertDatabaseHas($table, [
                'portfolio_id' => $dividend_entity->portfolioId(),
                'symbol' => $dividend_entity->symbol(),
                'amount' => $dividend_entity->amount(),
                'recorded_at' => $dividend_entity->recordedAt(),
            ]);

        });

        it('can update dividend when using store method.', function () {
            // Arrange:
            $dividend_model = DividendModel::factory()->create();

            $dividend_entity = new Dividend(
                portfolio_id: $dividend_model->portfolio->id,
                symbol: 'JFC',
                amount: 5000,
                id: $dividend_model->id,
            );

            // Act:
            $result = $this->repository->store($dividend_entity);

            // Assert:
            expect($result)->toBeInstanceOf(Dividend::class);

            $this->assertDatabaseHas('dividends', [
                'portfolio_id' => $dividend_entity->portfolioId(),
                'symbol' => $dividend_entity->symbol(),
                'amount' => $dividend_entity->amount(),
            ]);
        });

        it('can soft delete dividend when using trash method.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $this->repository->trash($dividend->id);

            // Assert:
            $this->assertSoftDeleted($dividend);
        });

        it('can restore trashed dividend when using restore method.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->trashed()->create();

            // Act:
            $this->repository->restore($dividend->id);

            // Assert:
            $this->assertNotSoftDeleted($dividend);
        });

        it('can hard delete dividend when using delete method.', function () {
            // Arrange:
            $dividend = DividendModel::factory()->create();

            // Act:
            $this->repository->delete($dividend->id);

            // Assert:
            $this->assertModelMissing($dividend);
            $this->assertDatabaseMissing($dividend);
        });

    });

    describe('Negatives', function () {

        it('can throw an exception when no record found upon using trash method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->trash($random_id);

            // Assert
        })->throws(ModelNotFoundException::class);

        it('can throw an exception when no record found upon using restore method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->restore($random_id);

            // Assert
        })->throws(ModelNotFoundException::class);

        it('can throw an exception when no record found upon using delete method.', function () {
            // Arrange:
            $random_id = rand(1, 10);

            // Act:
            $this->repository->delete($random_id);

            // Assert
        })->throws(ModelNotFoundException::class);
    });

});
