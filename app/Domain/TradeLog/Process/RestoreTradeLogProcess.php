<?php

namespace App\Domain\TradeLog\Process;

use App\Domain\TradeLog\Actions\RestoreTradeLogAction;
use App\Processes\AbstractProcess;

class RestoreTradeLogProcess extends AbstractProcess
{
    protected array $tasks = [
        RestoreTradeLogAction::class,
    ];
}
