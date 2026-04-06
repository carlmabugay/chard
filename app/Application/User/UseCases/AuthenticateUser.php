<?php

namespace App\Application\User\UseCases;

use App\Domain\User\Services\UserService;

class AuthenticateUser
{
    public function __construct(
        protected readonly UserService $service
    ) {}

    public function handle(array $credentials): bool|string
    {
        return $this->service->authenticate($credentials);
    }
}
