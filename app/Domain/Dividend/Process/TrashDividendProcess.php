<?php

namespace App\Domain\Dividend\Process;

use App\Domain\Dividend\Actions\TrashDividendAction;
use App\Processes\AbstractProcess;

class TrashDividendProcess extends AbstractProcess
{
    protected array $tasks = [
        TrashDividendAction::class,
    ];
}
