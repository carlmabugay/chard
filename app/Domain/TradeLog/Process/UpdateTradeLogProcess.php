<?php

namespace App\Domain\TradeLog\Process;

use App\Domain\TradeLog\Actions\UpdateTradeLogAction;
use App\Processes\AbstractProcess;

class UpdateTradeLogProcess extends AbstractProcess
{
    protected array $tasks = [
        UpdateTradeLogAction::class,
    ];
}
