<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\CreateNewStrategyAction;
use App\Processes\AbstractProcess;

class StrategyCreationProcess extends AbstractProcess
{
    protected array $tasks = [
        CreateNewStrategyAction::class,
    ];
}
