<?php

namespace App\Providers;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\Repositories\CashFlowRepository;
use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\Repositories\DividendRepository;
use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\Repositories\StrategyRepository;
use App\Domain\TradeLog\Contracts\TradeLogRepositoryInterface;
use App\Domain\TradeLog\Repositories\TradeLogRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public $bindings = [
        StrategyRepositoryInterface::class => StrategyRepository::class,
        PortfolioRepositoryInterface::class => PortfolioRepository::class,
        CashFlowRepositoryInterface::class => CashFlowRepository::class,
        DividendRepositoryInterface::class => DividendRepository::class,
        TradeLogRepositoryInterface::class => TradeLogRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
