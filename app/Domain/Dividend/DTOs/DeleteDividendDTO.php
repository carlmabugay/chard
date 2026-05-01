<?php

namespace App\Domain\Dividend\DTOs;

final class DeleteDividendDTO
{
    public function __construct(
        public int $id,
    ) {}
}
