<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\CollectStrategiesAction;
use App\Processes\AbstractProcess;

class StrategyCollectionProcess extends AbstractProcess
{
    protected array $tasks = [
        CollectStrategiesAction::class,
    ];
}
