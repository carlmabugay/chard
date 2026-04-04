<?php

use App\Application\Portolio\DTOs\StorePortfolioDTO;
use App\Application\Portolio\UseCases\StorePortfolio;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\User as UserModel;

describe('Integration: StorePortfolio Use Case', function () {

    it('can store portfolio when using handle method.', function () {
        // Arrange:
        $user = UserModel::factory()->create();

        $dto = StorePortfolioDTO::fromRequest([
            'user_id' => $user->id,
            'name' => 'PH Stock Market',
        ]);

        $portfolio_entity = Portfolio::fromDTO($dto);

        $service = Mockery::mock(PortfolioService::class);

        $use_case = new StorePortfolio($service);

        // Expectation:
        $service->shouldReceive('store')
            ->once()
            ->andReturn($portfolio_entity);

        // Act:
        $result = $use_case->handle($dto);

        // Assert:
        expect($result)
            ->toBeInstanceOf(Portfolio::class)
            ->and(($result->id()))->toBe($portfolio_entity->id())
            ->and($result->name())->toBe($portfolio_entity->name());
    });

});
