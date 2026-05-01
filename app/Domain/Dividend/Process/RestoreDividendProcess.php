<?php

namespace App\Domain\Dividend\Process;

use App\Domain\Dividend\Actions\RestoreDividendAction;
use App\Processes\AbstractProcess;

class RestoreDividendProcess extends AbstractProcess
{
    protected array $tasks = [
        RestoreDividendAction::class,
    ];
}
