<?php

namespace App\Domain\Common\Query;

class Filter
{
    public function __construct(
        public readonly string $field,
        public readonly string $operator,
        public readonly mixed $value,
    ) {}
}
