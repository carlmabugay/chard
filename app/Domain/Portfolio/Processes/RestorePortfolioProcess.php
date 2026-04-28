<?php

namespace App\Domain\Portfolio\Processes;

use App\Domain\Portfolio\Actions\RestorePortfolioAction;
use App\Processes\AbstractProcess;

class RestorePortfolioProcess extends AbstractProcess
{
    protected array $tasks = [
        RestorePortfolioAction::class,
    ];
}
