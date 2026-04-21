<?php

namespace App\Processes;

use App\Actions\CreateNewStrategyAction;

final class StrategyCreationProcess extends AbstractProcess
{
    protected array $tasks = [
        CreateNewStrategyAction::class,
    ];
}
