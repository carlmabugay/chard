<?php

namespace App\Domain\CashFlow\Process;

use App\Domain\CashFlow\Actions\DeleteCashFlowAction;
use App\Processes\AbstractProcess;

class DeleteCashFlowProcess extends AbstractProcess
{
    protected array $tasks = [
        DeleteCashFlowAction::class,
    ];
}
