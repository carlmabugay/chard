<?php

use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: EloquentPortfolioReadRepository', function () {

    it('should return all portfolio when using fetchAll method.', function () {

        $count = 10;

        PortfolioModel::factory(10)->create();

        $repository = new EloquentPortfolioReadRepository;

        $portfolios = $repository->fetchAll();

        expect($portfolios)->toHaveCount($count);

    });
});
