<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\TrashStrategyAction;
use App\Processes\AbstractProcess;

class TrashStrategyProcess extends AbstractProcess
{
    protected array $tasks = [
        TrashStrategyAction::class,
    ];
}
