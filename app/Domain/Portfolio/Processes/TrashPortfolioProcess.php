<?php

namespace App\Domain\Portfolio\Processes;

use App\Domain\Portfolio\Actions\TrashPortfolioAction;
use App\Processes\AbstractProcess;

class TrashPortfolioProcess extends AbstractProcess
{
    protected array $tasks = [
        TrashPortfolioAction::class,
    ];
}
