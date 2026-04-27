<?php

namespace App\Domain\Portfolio\Processes;

use App\Domain\Portfolio\Actions\StorePortfolioAction;
use App\Processes\AbstractProcess;

class StorePortfolioProcess extends AbstractProcess
{
    protected array $tasks = [
        StorePortfolioAction::class,
    ];
}
