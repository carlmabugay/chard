<?php

use App\Application\DTOs\StorePortfolioDTO;
use App\Application\UseCases\StorePortfolio;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: Store Portfolio', function () {

    it('should store portfolio when using handle method.', function () {

        // Arrange:
        $user = UserModel::factory()->create();

        $dto = StorePortfolioDTO::fromArray([
            'user_id' => $user->id,
            'name' => 'PH Stock Market',
        ]);

        $portfolio_entity = new Portfolio(
            user_id: $dto->user_id,
            name: $dto->name,
        );

        $service = Mockery::mock(PortfolioService::class);

        // Expectation:
        $service->shouldReceive('store')
            ->once();

        // Act:
        $use_case = new StorePortfolio($service);
        $use_case->handle($dto);

        // Assert:
    });
});
