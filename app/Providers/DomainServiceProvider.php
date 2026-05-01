<?php

namespace App\Providers;

use App\Application\Dividend\UseCases\DeleteDividend;
use App\Application\Dividend\UseCases\RestoreDividend;
use App\Application\Dividend\UseCases\StoreDividend;
use App\Application\Dividend\UseCases\TrashDividend;
use App\Application\TradeLog\UseCases\DeleteTradeLog;
use App\Application\TradeLog\UseCases\GetTradeLog;
use App\Application\TradeLog\UseCases\ListTradeLogs;
use App\Application\TradeLog\UseCases\RestoreTradeLog;
use App\Application\TradeLog\UseCases\StoreTradeLog;
use App\Application\TradeLog\UseCases\TrashTradeLog;
use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\Repositories\CashFlowRepository;
use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\Contracts\Persistence\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;
use App\Domain\Dividend\Contracts\UseCases\DeleteDividendInterface;
use App\Domain\Dividend\Contracts\UseCases\RestoreDividendInterface;
use App\Domain\Dividend\Contracts\UseCases\StoreDividendInterface;
use App\Domain\Dividend\Contracts\UseCases\TrashDividendInterface;
use App\Domain\Dividend\Repositories\DividendRepository;
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
use App\Infrastructure\Persistence\Eloquent\Read\EloquentTradeLogReadRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentDividendWriteRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentTradeLogWriteRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public $bindings = [
        DividendWriteRepositoryInterface::class => EloquentDividendWriteRepository::class,
        DividendServiceInterface::class => DividendService::class,
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
        CashFlowRepositoryInterface::class => CashFlowRepository::class,
        DividendRepositoryInterface::class => DividendRepository::class,
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
