<?php

namespace App\Domain\Dividend\Process;

use App\Domain\Dividend\Actions\DeleteDividendAction;
use App\Processes\AbstractProcess;

class DeleteDividendProcess extends AbstractProcess
{
    protected array $tasks = [
        DeleteDividendAction::class,
    ];
}
