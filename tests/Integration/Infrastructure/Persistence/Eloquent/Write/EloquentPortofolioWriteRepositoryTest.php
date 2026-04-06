<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->repository = new EloquentPortfolioWriteRepository;
});

describe('Integration: EloquentPortfolioWriteRepository', function () {

    describe('Positives', function () {

        it('can create new portfolio when using store method.', function () {

            // Arrange
            $table = 'portfolios';
            $user = UserModel::factory()->create();
            $portfolio_name = 'PH Stock Market';

            $portfolio = new Portfolio(
                user_id: $user->id,
                name: $portfolio_name,
            );

            // Act:
            $result = $this->repository->store($portfolio);

            // Assert:
            expect($result)->toBeInstanceOf(Portfolio::class);

            $this->assertDatabaseCount($table, 1);
            $this->assertDatabaseHas($table, [
                'user_id' => $portfolio->userId(),
                'name' => $portfolio->name(),
            ]);
        });

        it('can update portfolio when using store method.', function () {

            // Arrange:
            $user = UserModel::factory()->create();
            $portfolio_model = PortfolioModel::factory()->create();

            $portfolio_entity = new Portfolio(
                user_id: $user->id,
                name: 'Dividend Investment',
                id: $portfolio_model->id,
            );

            // Act:
            $result = $this->repository->store($portfolio_entity);

            // Assert:
            expect($result)->toBeInstanceOf(Portfolio::class);

            $this->assertDatabaseHas('portfolios', [
                'user_id' => $portfolio_entity->userId(),
                'name' => $portfolio_entity->name(),
                'id' => $portfolio_entity->id(),
            ]);

        });

        it('can soft delete portfolio when using trash method.', function () {

            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            // Act:
            $result = $this->repository->trash($portfolio->id);

            // Assert
            $this->assertSoftDeleted($portfolio);

            expect($result)->toBeTrue();
        });

        it('can restore trashed portfolio when using restore method.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->trashed()->create();

            // Act:
            $result = $this->repository->restore($portfolio->id);

            // Assert
            $this->assertNotSoftDeleted($portfolio);
        });

        it('can hard delete portfolio when using delete method.', function () {
            // Arrange:
            $portfolio = PortfolioModel::factory()->create();

            // Act:
            $this->repository->delete($portfolio->id);

            // Assert:
            $this->assertModelMissing($portfolio);
            $this->assertDatabaseMissing($portfolio);
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
