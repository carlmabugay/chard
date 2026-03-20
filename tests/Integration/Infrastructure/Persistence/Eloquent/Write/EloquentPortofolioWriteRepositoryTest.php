<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;

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
        $repository = new EloquentPortfolioWriteRepository;

        $stored_portfolio = $repository->store($portfolio);

        // Assert:
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'user_id' => $user->id,
            'name' => $portfolio_name,
        ]);

        expect($stored_portfolio)->toBeInstanceOf(Portfolio::class);
    });

    it('should update portfolio when using store method.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $portfolio_model = PortfolioModel::factory()->create();
        $new_portfolio_name = 'Dividend Investment';

        $portfolio_entity = new Portfolio(
            user_id: $user->id,
            name: $new_portfolio_name,
            id: $portfolio_model->id,
        );

        // Act:
        $repository = new EloquentPortfolioWriteRepository;

        $updated_portfolio = $repository->store($portfolio_entity);

        // Assert:
        $this->assertDatabaseHas('portfolios', [
            'user_id' => $user->id,
            'id' => $portfolio_model->id,
            'name' => $new_portfolio_name,
        ]);

        expect($updated_portfolio)->toBeInstanceOf(Portfolio::class);
    });

});
