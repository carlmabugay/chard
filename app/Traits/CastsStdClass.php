<?php

namespace App\Traits;

use stdClass;

trait CastsStdClass
{
    public static function fromStdClass(stdClass $data): self
    {
        return (new static)->fill((array) $data);
    }
}
