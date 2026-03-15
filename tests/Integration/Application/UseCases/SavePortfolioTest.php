<?php

use App\Application\DTOs\SavePortfolioDTO;
use App\Application\UseCases\SavePortfolio;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('Integration: Save Portfolio', function () {

    it('should save portfolio when using handle method.', function () {

        // Arrange:
        $user = UserModel::factory()->create();

        $dto = SavePortfolioDTO::fromArray([
            'user_id' => $user->id,
            'name' => 'PH Stock Market',
        ]);

        $portfolio_entity = new Portfolio(
            user_id: $dto->user_id,
            name: $dto->name,
        );

        $service = Mockery::mock(PortfolioService::class);

        // Expectation:
        $service->shouldReceive('save')
            ->once();

        // Act:
        $use_case = new SavePortfolio($service);
        $use_case->handle($dto);

        // Assert:
    });
});
