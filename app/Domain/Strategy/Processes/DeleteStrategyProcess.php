<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\DeleteStrategyAction;
use App\Processes\AbstractProcess;

class DeleteStrategyProcess extends AbstractProcess
{
    protected array $tasks = [
        DeleteStrategyAction::class,
    ];
}
