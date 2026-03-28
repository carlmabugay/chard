<?php

namespace App\Domain\Common\Query;

class QueryCriteria
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $per_page = 20,
        public readonly ?string $search = null,
        public readonly array $filters = [],
        public readonly array $sorts = [],
    ) {}
}
