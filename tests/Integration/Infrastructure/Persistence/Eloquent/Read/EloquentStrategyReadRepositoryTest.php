<?php

use App\Infrastructure\Persistence\Eloquent\Read\EloquentStrategyReadRepository;
use App\Models\Strategy as StrategyModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->repository = new EloquentStrategyReadRepository;
});

describe('Integration: EloquentStrategyReadRepository', function () {

    it('should return all strategies when using fetchAll method.', function () {

        // Arrange:
        $count = 10;
        StrategyModel::factory(10)->create();

        // Act:
        $portfolios = $this->repository->fetchAll();

        // Assert:
        expect($portfolios)
            ->toBeArray()
            ->toHaveCount($count);

    });

});
