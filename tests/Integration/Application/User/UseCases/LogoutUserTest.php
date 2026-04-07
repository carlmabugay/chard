<?php

use App\Application\User\UseCases\LogoutUser;
use App\Domain\User\Services\UserService;

describe('Integration: LogoutUser Use Case', function () {

    it('can sign out authenticated user when using handle method.', function () {
        // Arrange:
        $mock_request = Request::create('api/v1/user/logout', 'POST');
        $service = Mockery::mock(UserService::class);

        $use_case = new LogoutUser($service);

        // Expectation:
        $service->shouldReceive('logout')
            ->once()
            ->with($mock_request)
            ->andReturnNull();

        // Act:
        $use_case->handle($mock_request);

        // Assert:
    });
});
