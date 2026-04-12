<?php

namespace App\Providers;

use App\Application\CashFlow\UserCases\DeleteCashFlow;
use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Application\CashFlow\UserCases\ListCashFlows;
use App\Application\CashFlow\UserCases\RestoreCashFlow;
use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Application\CashFlow\UserCases\TrashCashFlow;
use App\Application\Portolio\UseCases\DeletePortfolio;
use App\Application\Portolio\UseCases\GetPortfolio;
use App\Application\Portolio\UseCases\ListPortfolios;
use App\Application\Portolio\UseCases\RestorePortfolio;
use App\Application\Portolio\UseCases\StorePortfolio;
use App\Application\Portolio\UseCases\TrashPortfolio;
use App\Application\Strategy\UseCases\DeleteStrategy;
use App\Application\Strategy\UseCases\GetStrategy;
use App\Application\Strategy\UseCases\ListStrategies;
use App\Application\Strategy\UseCases\RestoreStrategy;
use App\Application\Strategy\UseCases\StoreStrategy;
use App\Application\Strategy\UseCases\TrashStrategy;
use App\Domain\CashFlow\Contracts\Persistence\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Contracts\Persistence\Write\CashFlowWriteRepositoryInterface;
use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\DeleteCashFlowInterface;
use App\Domain\CashFlow\Contracts\UseCases\GetCashFlowInterface;
use App\Domain\CashFlow\Contracts\UseCases\ListCashFlowsInterface;
use App\Domain\CashFlow\Contracts\UseCases\RestoreCashFlowInterface;
use App\Domain\CashFlow\Contracts\UseCases\StoreCashFlowInterface;
use App\Domain\CashFlow\Contracts\UseCases\TrashCashFlowInterface;
use App\Domain\CashFlow\Services\CashFlowService;
use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Contracts\Write\DividendWriteRepositoryInterface;
use App\Domain\Portfolio\Contracts\Persistence\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Persistence\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\Portfolio\Contracts\UseCases\DeletePortfolioInterface;
use App\Domain\Portfolio\Contracts\UseCases\GetPortfolioInterface;
use App\Domain\Portfolio\Contracts\UseCases\ListPortfoliosInterface;
use App\Domain\Portfolio\Contracts\UseCases\RestorePortfolioInterface;
use App\Domain\Portfolio\Contracts\UseCases\StorePortfolioInterface;
use App\Domain\Portfolio\Contracts\UseCases\TrashPortfolioInterface;
use App\Domain\Portfolio\Services\PortfolioService;
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
        PortfolioServiceInterface::class => PortfolioService::class,
        ListPortfoliosInterface::class => ListPortfolios::class,
        StorePortfolioInterface::class => StorePortfolio::class,
        GetPortfolioInterface::class => GetPortfolio::class,
        TrashPortfolioInterface::class => TrashPortfolio::class,
        RestorePortfolioInterface::class => RestorePortfolio::class,
        DeletePortfolioInterface::class => DeletePortfolio::class,

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
        CashFlowServiceInterface::class => CashFlowService::class,
        ListCashFlowsInterface::class => ListCashFlows::class,
        StoreCashFlowInterface::class => StoreCashFlow::class,
        GetCashFlowInterface::class => GetCashFlow::class,
        TrashCashFlowInterface::class => TrashCashFlow::class,
        RestoreCashFlowInterface::class => RestoreCashFlow::class,
        DeleteCashFlowInterface::class => DeleteCashFlow::class,

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
