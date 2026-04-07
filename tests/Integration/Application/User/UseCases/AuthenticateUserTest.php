<?php

use App\Application\User\UseCases\AuthenticateUser;
use App\Domain\User\Services\UserService;

describe('Integration: AuthenticateUser Use Case', function () {

    it('can authenticate user when using handle method.', function () {
        // Arrange:
        $credentials = [
            'email' => 'email@test.com',
            'password' => 'password',
        ];

        $mock_token = 'fake-token-value';

        $service = Mockery::mock(UserService::class);

        $use_case = new AuthenticateUser($service);

        // Expectation:
        $service->shouldReceive('authenticate')
            ->once()
            ->with($credentials)
            ->andReturn($mock_token);

        // Act:
        $result = $use_case->handle($credentials);

        // Assert
        expect($result)->toBe($mock_token);
    });

    it('can return failed authentication attempt when using handle method.', function () {
        // Arrange:
        $credentials = [
            'email' => 'email@test.com',
            'password' => 'password',
        ];

        $service = Mockery::mock(UserService::class);

        $use_case = new AuthenticateUser($service);

        // Expectation:
        $service->shouldReceive('authenticate')
            ->once()
            ->with($credentials)
            ->andReturn(false);

        // Act:
        $result = $use_case->handle($credentials);

        // Assert
        expect($result)->toBeFalse();
    });

});
