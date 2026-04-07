<?php

namespace App\Application\User\UseCases;

use App\Domain\User\Services\UserService;
use Illuminate\Http\Request;

class LogoutUser
{
    public function __construct(
        protected UserService $service
    ) {}

    public function handle(Request $request): void
    {
        $this->service->logout($request);
    }
}
