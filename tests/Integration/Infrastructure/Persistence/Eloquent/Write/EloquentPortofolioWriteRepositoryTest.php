<?php

use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: EloquentPortfolioReadRepository', function () {

    it('should create new portfolio when using save method.', function () {

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

        $repository->store($portfolio);

        // Assert:
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'user_id' => $user->id,
            'name' => $portfolio_name,
        ]);
    });

});
