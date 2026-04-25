<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\CreateStrategyAction;
use App\Processes\AbstractProcess;

class CreateStrategyProcess extends AbstractProcess
{
    protected array $tasks = [
        CreateStrategyAction::class,
    ];
}
