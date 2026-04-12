<?php

namespace App\Providers;

use App\Application\Strategy\UseCases\DeleteStrategy;
use App\Application\Strategy\UseCases\GetStrategy;
use App\Application\Strategy\UseCases\ListStrategies;
use App\Application\Strategy\UseCases\RestoreStrategy;
use App\Application\Strategy\UseCases\StoreStrategy;
use App\Application\Strategy\UseCases\TrashStrategy;
use App\Domain\CashFlow\Contracts\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Contracts\Write\CashFlowWriteRepositoryInterface;
use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Contracts\Write\DividendWriteRepositoryInterface;
use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Strategy\Contracts\Persistence\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Contracts\Persistence\Write\StrategyWriteRepositoryInterface;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\DeleteStrategyInterface;
use App\Domain\Strategy\Contracts\UseCases\GetStrategyInterface;
use App\Domain\Strategy\Contracts\UseCases\ListStrategiesInterface;
use App\Domain\Strategy\Contracts\UseCases\RestoreStrategyInterface;
use App\Domain\Strategy\Contracts\UseCases\StoreStrategyInterface;
use App\Domain\Strategy\Contracts\UseCases\TrashStrategyInterface;
use App\Domain\Strategy\Services\StrategyService;
use App\Domain\TradeLog\Contracts\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Contracts\Write\TradeLogWriteRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentCashFlowReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentDividendReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentStrategyReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentTradeLogReadRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentCashFlowWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentStrategyWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentTradeLogWriteRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public $bindings = [
        PortfolioReadRepositoryInterface::class => EloquentPortfolioReadRepository::class,
        PortfolioWriteRepositoryInterface::class => EloquentPortfolioWriteRepository::class,

        StrategyReadRepositoryInterface::class => EloquentStrategyReadRepository::class,
        StrategyWriteRepositoryInterface::class => EloquentStrategyWriteRepository::class,

        StrategyServiceInterface::class => StrategyService::class,
        ListStrategiesInterface::class => ListStrategies::class,
        StoreStrategyInterface::class => StoreStrategy::class,
        GetStrategyInterface::class => GetStrategy::class,
        TrashStrategyInterface::class => TrashStrategy::class,
        RestoreStrategyInterface::class => RestoreStrategy::class,
        DeleteStrategyInterface::class => DeleteStrategy::class,

        CashFlowReadRepositoryInterface::class => EloquentCashFlowReadRepository::class,
        CashFlowWriteRepositoryInterface::class => EloquentCashFlowWriteRepository::class,

        DividendReadRepositoryInterface::class => EloquentDividendReadRepository::class,
        DividendWriteRepositoryInterface::class => EloquentDividendWriteRepository::class,

        TradeLogReadRepositoryInterface::class => EloquentTradeLogReadRepository::class,
        TradeLogWriteRepositoryInterface::class => EloquentTradeLogWriteRepository::class,
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
