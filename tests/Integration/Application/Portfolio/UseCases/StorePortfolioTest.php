<?php

use App\Application\Portolio\DTOs\StorePortfolioDTO;
use App\Application\Portolio\UseCases\StorePortfolio;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\User as UserModel;

describe('Integration: StorePortfolio Use Case', function () {

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
            ->once()
            ->andReturn($portfolio_entity);

        // Act:
        $use_case = new StorePortfolio($service);
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)->toBeInstanceOf(Portfolio::class);
    });
});
