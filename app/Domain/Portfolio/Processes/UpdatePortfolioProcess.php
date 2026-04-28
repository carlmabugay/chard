<?php

namespace App\Domain\Portfolio\Processes;

use App\Domain\Portfolio\Actions\UpdatePortfolioAction;
use App\Processes\AbstractProcess;

class UpdatePortfolioProcess extends AbstractProcess
{
    protected array $tasks = [
        UpdatePortfolioAction::class,
    ];
}
