<?php

use App\Models\Portfolio as PortfolioModel;
use Laravel\Sanctum\Sanctum;

describe('Feature: TrashPortfolioController', function () {

    it('should soft delete portfolio resource when using /api/v1/portfolios DELETE api endpoint.', function () {

        // Arrange:
        $portfolio = PortfolioModel::factory()->create();

        Sanctum::actingAs($portfolio->user);

        // Act:
        $response = $this->delete(sprintf('%s/%s', '/api/v1/portfolios', $portfolio->id));

        // Assert:
        $this->assertSoftDeleted($portfolio);

        $response->assertOk()
            ->assertJson([
                'success' => $response,
            ]);
    });

});
