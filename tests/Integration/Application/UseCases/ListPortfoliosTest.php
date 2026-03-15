<?php

use App\Application\UseCases\ListPortfolios;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: List of all Portfolios', function () {

    it('should list all portfolios when using handle method.', function () {

        // Arrange:
        $count = 10;
        $portfolios = PortfolioModel::factory()->count($count)->create();

        $service = Mockery::mock(PortfolioService::class);

        $use_case = new ListPortfolios($service);

        $service->shouldReceive('fetchAll')
            ->once()
            ->andReturn([
                $portfolios,
            ]);

        // Act:
        $result = $use_case->handle();

        // Assert:
        expect($result[0])->toHaveCount($count);

    });
});
