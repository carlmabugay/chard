<?php

namespace App\Domain\CashFlow\Process;

use App\Domain\CashFlow\Actions\UpdateCashFlowAction;
use App\Processes\AbstractProcess;

class UpdateCashFlowProcess extends AbstractProcess
{
    protected array $tasks = [
        UpdateCashFlowAction::class,
    ];
}
