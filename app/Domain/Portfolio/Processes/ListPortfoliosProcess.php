<?php

namespace App\Domain\Portfolio\Processes;

use App\Domain\Portfolio\Actions\ListPortfoliosAction;
use App\Processes\AbstractProcess;

class ListPortfoliosProcess extends AbstractProcess
{
    protected array $tasks = [
        ListPortfoliosAction::class,
    ];
}
