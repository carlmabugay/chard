<?php

namespace App\Domain\Common\Query;

class Sort
{
    public function __construct(
        public readonly string $field,
        public readonly string $direction = 'asc',
    ) {}
}
