<?php

namespace App\Domain\Portfolio\Entities;

class Portfolio
{
    public function __construct(
        private int $user_id,
        private int $id,
        private string $name,
        private string $created_at,
        private string $updated_at,
    ) {}
}
