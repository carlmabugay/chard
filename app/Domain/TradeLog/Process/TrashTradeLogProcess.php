<?php

namespace App\Domain\TradeLog\Process;

use App\Domain\TradeLog\Actions\TrashTradeLogAction;
use App\Processes\AbstractProcess;

class TrashTradeLogProcess extends AbstractProcess
{
    protected array $tasks = [
        TrashTradeLogAction::class,
    ];
}
