<?php

namespace App\Domain\Dividend\Process;

use App\Domain\Dividend\Actions\StoreDividendAction;
use App\Processes\AbstractProcess;

class StoreDividendProcess extends AbstractProcess
{
    protected array $tasks = [
        StoreDividendAction::class,
    ];
}
