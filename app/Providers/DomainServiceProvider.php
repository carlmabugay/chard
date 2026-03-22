<?php

namespace App\Providers;

use App\Domain\CashFlow\Contracts\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Contracts\Write\CashFlowWriteRepositoryInterface;
use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Contracts\Write\DividendWriteRepositoryInterface;
use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Strategy\Contracts\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Contracts\Write\StrategyWriteRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentCashFlowReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentDividendReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentStrategyReadRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentCashFlowWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentStrategyWriteRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public $bindings = [
        PortfolioReadRepositoryInterface::class => EloquentPortfolioReadRepository::class,
        PortfolioWriteRepositoryInterface::class => EloquentPortfolioWriteRepository::class,

        StrategyReadRepositoryInterface::class => EloquentStrategyReadRepository::class,
        StrategyWriteRepositoryInterface::class => EloquentStrategyWriteRepository::class,

        CashFlowReadRepositoryInterface::class => EloquentCashFlowReadRepository::class,
        CashFlowWriteRepositoryInterface::class => EloquentCashFlowWriteRepository::class,

        DividendReadRepositoryInterface::class => EloquentDividendReadRepository::class,
        DividendWriteRepositoryInterface::class => EloquentDividendWriteRepository::class,
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
    public function boot(): void
    {
        //
    }
}
