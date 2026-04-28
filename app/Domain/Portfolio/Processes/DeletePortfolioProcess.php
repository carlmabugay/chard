<?php

namespace App\Domain\Portfolio\Processes;

use App\Domain\Portfolio\Actions\DeletePortfolioAction;
use App\Processes\AbstractProcess;

class DeletePortfolioProcess extends AbstractProcess
{
    protected array $tasks = [
        DeletePortfolioAction::class,
    ];
}
