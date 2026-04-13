<?php

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;
use App\Models\Portfolio as PortfolioModel;
use App\Models\User as UserModel;

beforeEach(function () {
    $this->repository = new EloquentPortfolioWriteRepository;
});

describe('Integration: EloquentPortfolioWriteRepository', function () {

    it('can create new portfolio when using store method.', function () {

        // Arrange
        $table = 'portfolios';
        $user = UserModel::factory()->create();
        $portfolio_name = 'PH Stock Market';

        $dto = new PortfolioDTO(
            user_id: $user->id,
            name: $portfolio_name,
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(Portfolio::class);

        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'user_id' => $dto->userId(),
            'name' => $dto->name(),
        ]);
    });

    it('can update portfolio when using store method.', function () {

        // Arrange:
        $user = UserModel::factory()->create();
        $portfolio_model = PortfolioModel::factory()->create();

        $dto = new PortfolioDTO(
            user_id: $user->id,
            name: 'New Portfolio Name',
            id: $portfolio_model->id,
        );

        // Act:
        $result = $this->repository->store($dto);

        // Assert:
        expect($result)->toBeInstanceOf(Portfolio::class);

        $this->assertDatabaseHas('portfolios', [
            'user_id' => $dto->userId(),
            'name' => $dto->name(),
            'id' => $dto->id(),
        ]);

    });

    it('can soft delete portfolio when using trash method.', function () {

        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $dto = PortfolioDTO::fromModel($portfolio);

        // Act:
        $result = $this->repository->trash($dto);

        // Assert
        $this->assertSoftDeleted($portfolio);

        expect($result)->toBeTrue();
    });

    it('can restore trashed portfolio when using restore method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()->trashed()->create();

        $dto = PortfolioDTO::fromModel($portfolio);

        // Act:
        $this->repository->restore($dto);

        // Assert
        $this->assertNotSoftDeleted($portfolio);
    });

    it('can hard delete portfolio when using delete method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        $dto = PortfolioDTO::fromModel($portfolio);

        // Act:
        $this->repository->delete($dto);

        // Assert:
        $this->assertModelMissing($portfolio);
        $this->assertDatabaseMissing($portfolio);
    });

    it('can delete associated child records when a portfolio is hard deleted using delete method.', function () {
        // Arrange:
        $portfolio = PortfolioModel::factory()
            ->hasCashFlows()
            ->hasDividends()
            ->hasTradeLogs()
            ->create();

        $dto = PortfolioDTO::fromModel($portfolio);

        // Act:
        $this->repository->delete($dto);

        // Assert:
        $this->assertDatabaseMissing($portfolio);
        $this->assertDatabaseMissing('cash_flows', $portfolio->cashFlows->all());
        $this->assertDatabaseMissing('dividends', $portfolio->dividends->all());
        $this->assertDatabaseMissing('trade_logs', $portfolio->tradeLogs->all());
    });

});
