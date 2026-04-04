<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;

beforeEach(function () {
    $this->repository = new EloquentPortfolioWriteRepository;
});

describe('Integration: EloquentPortfolioWriteRepository', function () {

    it('should create new portfolio when using store method.', function () {

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
            'user_id' => $result->userId(),
            'name' => $result->name(),
            'id' => $result->id(),
        ]);
    });

    it('should update portfolio when using store method.', function () {

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
            'user_id' => $result->userId(),
            'name' => $result->name(),
            'id' => $result->id(),
        ]);

    });

    it(' should soft delete portfolio when using trash method.', function () {

        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        // Act:
        $result = $this->repository->trash($portfolio->id);

        // Assert
        $this->assertSoftDeleted($portfolio);

        expect($result)->toBeTrue();
    });

});
