<?php

namespace App\Domain\CashFlow\Process;

use App\Domain\CashFlow\Actions\ListCashFlowAction;
use App\Processes\AbstractProcess;

class ListCashFlowsProcess extends AbstractProcess
{
    protected array $tasks = [
        ListCashFlowAction::class,
    ];
}
