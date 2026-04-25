<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\UpdateStrategyAction;
use App\Processes\AbstractProcess;

class UpdateStrategyProcess extends AbstractProcess
{
    protected array $tasks = [
        UpdateStrategyAction::class,
    ];
}
