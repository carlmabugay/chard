<?php

namespace App\Domain\Dividend\Process;

use App\Domain\Dividend\Actions\ListDividendsAction;
use App\Processes\AbstractProcess;

class ListDividendsProcess extends AbstractProcess
{
    protected array $tasks = [
        ListDividendsAction::class,
    ];
}
