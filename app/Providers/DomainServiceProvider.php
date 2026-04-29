<?php

namespace App\Providers;

use App\Application\CashFlow\UserCases\DeleteCashFlow;
use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Application\CashFlow\UserCases\ListCashFlows;
use App\Application\CashFlow\UserCases\RestoreCashFlow;
use App\Application\CashFlow\UserCases\StoreCashFlow;
use App\Application\CashFlow\UserCases\TrashCashFlow;
use App\Application\Dividend\UseCases\DeleteDividend;
use App\Application\Dividend\UseCases\GetDividend;
use App\Application\Dividend\UseCases\ListDividends;
use App\Application\Dividend\UseCases\RestoreDividend;
use App\Application\Dividend\UseCases\StoreDividend;
use App\Application\Dividend\UseCases\TrashDividend;
use App\Application\TradeLog\UseCases\DeleteTradeLog;
use App\Application\TradeLog\UseCases\GetTradeLog;
use App\Application\TradeLog\UseCases\ListTradeLogs;
use App\Application\TradeLog\UseCases\RestoreTradeLog;
use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Application\TradeLog\UseCases\TrashTradeLog;
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
use App\Domain\Dividend\Contracts\Persistence\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Contracts\Persistence\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;
use App\Domain\Dividend\Contracts\UseCases\DeleteDividendInterface;
use App\Domain\Dividend\Contracts\UseCases\GetDividendInterface;
use App\Domain\Dividend\Contracts\UseCases\ListDividendsInterface;
use App\Domain\Dividend\Contracts\UseCases\RestoreDividendInterface;
use App\Domain\Dividend\Contracts\UseCases\StoreDividendInterface;
use App\Domain\Dividend\Contracts\UseCases\TrashDividendInterface;
use App\Domain\Dividend\Services\DividendService;
use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\Repositories\StrategyRepository;
use App\Domain\TradeLog\Contracts\Persistence\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Contracts\Persistence\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\DeleteTradeLogInterface;
use App\Domain\TradeLog\Contracts\UseCases\GetTradeLogInterface;
use App\Domain\TradeLog\Contracts\UseCases\ListTradeLogsInterface;
use App\Domain\TradeLog\Contracts\UseCases\RestoreTradeLogInterface;
use App\Domain\TradeLog\Contracts\UseCases\StoreTradeLogInterface;
use App\Domain\TradeLog\Contracts\UseCases\TrashTradeLogInterface;
use App\Domain\TradeLog\Services\TradeLogService;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentCashFlowReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentDividendReadRepository;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentTradeLogReadRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentCashFlowWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentTradeLogWriteRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public $bindings = [
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
        DividendServiceInterface::class => DividendService::class,
        ListDividendsInterface::class => ListDividends::class,
        GetDividendInterface::class => GetDividend::class,
        StoreDividendInterface::class => StoreDividend::class,
        TrashDividendInterface::class => TrashDividend::class,
        RestoreDividendInterface::class => RestoreDividend::class,
        DeleteDividendInterface::class => DeleteDividend::class,

        TradeLogReadRepositoryInterface::class => EloquentTradeLogReadRepository::class,
        TradeLogWriteRepositoryInterface::class => EloquentTradeLogWriteRepository::class,
        TradeLogServiceInterface::class => TradeLogService::class,
        ListTradeLogsInterface::class => ListTradeLogs::class,
        StoreTradeLogInterface::class => StoreTradeLog::class,
        GetTradeLogInterface::class => GetTradeLog::class,
        TrashTradeLogInterface::class => TrashTradeLog::class,
        RestoreTradeLogInterface::class => RestoreTradeLog::class,
        DeleteTradeLogInterface::class => DeleteTradeLog::class,

        StrategyRepositoryInterface::class => StrategyRepository::class,
        PortfolioRepositoryInterface::class => PortfolioRepository::class,
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
