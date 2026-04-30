<?php

namespace App\Domain\CashFlow\Process;

use App\Domain\CashFlow\Actions\TrashCashFlowAction;
use App\Processes\AbstractProcess;

class TrashCashFlowProcess extends AbstractProcess
{
    protected array $tasks = [
        TrashCashFlowAction::class,
    ];
}
