<?php

namespace App\Application\User\UseCases;

use App\Domain\User\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticateUser
{
    public function __construct(
        protected readonly UserService $service
    ) {}

    public function handle(FormRequest $request): bool|string
    {
        return $this->service->authenticate($request);
    }
}
