<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\ReviseStrategyAction;
use App\Processes\AbstractProcess;

class StrategyRevisionProcess extends AbstractProcess
{
    protected array $tasks = [
        ReviseStrategyAction::class,
    ];
}
