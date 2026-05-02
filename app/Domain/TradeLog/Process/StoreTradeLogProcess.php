<?php

namespace App\Domain\TradeLog\Process;

use App\Domain\TradeLog\Actions\StoreTradeLogAction;
use App\Processes\AbstractProcess;

class StoreTradeLogProcess extends AbstractProcess
{
    protected array $tasks = [
        StoreTradeLogAction::class,
    ];
}
