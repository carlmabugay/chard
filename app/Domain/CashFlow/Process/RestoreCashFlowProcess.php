<?php

namespace App\Domain\CashFlow\Process;

use App\Domain\CashFlow\Actions\RestoreCashFlowAction;
use App\Processes\AbstractProcess;

class RestoreCashFlowProcess extends AbstractProcess
{
    protected array $tasks = [
        RestoreCashFlowAction::class,
    ];
}
