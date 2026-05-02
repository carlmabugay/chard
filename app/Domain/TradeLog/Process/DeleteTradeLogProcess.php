<?php

namespace App\Domain\TradeLog\Process;

use App\Domain\TradeLog\Actions\DeleteTradeLogAction;
use App\Processes\AbstractProcess;

class DeleteTradeLogProcess extends AbstractProcess
{
    protected array $tasks = [
        DeleteTradeLogAction::class,
    ];
}
