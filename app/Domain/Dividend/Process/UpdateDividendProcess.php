<?php

namespace App\Domain\Dividend\Process;

use App\Domain\Dividend\Actions\UpdateDividendAction;
use App\Processes\AbstractProcess;

class UpdateDividendProcess extends AbstractProcess
{
    protected array $tasks = [
        UpdateDividendAction::class,
    ];
}
