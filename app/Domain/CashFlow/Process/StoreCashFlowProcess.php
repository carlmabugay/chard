<?php

namespace App\Domain\CashFlow\Process;

use App\Domain\CashFlow\Actions\StoreCashFlowAction;
use App\Processes\AbstractProcess;

class StoreCashFlowProcess extends AbstractProcess
{
    protected array $tasks = [
        StoreCashFlowAction::class,
    ];
}
