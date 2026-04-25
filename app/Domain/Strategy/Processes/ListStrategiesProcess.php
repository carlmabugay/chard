<?php

namespace App\Domain\Strategy\Processes;

use App\Domain\Strategy\Actions\ListStrategiesAction;
use App\Processes\AbstractProcess;

class ListStrategiesProcess extends AbstractProcess
{
    protected array $tasks = [
        ListStrategiesAction::class,
    ];
}
