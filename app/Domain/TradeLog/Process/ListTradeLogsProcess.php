<?php

namespace App\Domain\TradeLog\Process;

use App\Domain\TradeLog\Actions\ListTradeLogsAction;
use App\Processes\AbstractProcess;

class ListTradeLogsProcess extends AbstractProcess
{
    protected array $tasks = [
        ListTradeLogsAction::class,
    ];
}
