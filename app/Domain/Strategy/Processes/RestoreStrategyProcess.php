<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\RestoreStrategyAction;
use App\Processes\AbstractProcess;

class RestoreStrategyProcess extends AbstractProcess
{
    protected array $tasks = [
        RestoreStrategyAction::class,
    ];
}
