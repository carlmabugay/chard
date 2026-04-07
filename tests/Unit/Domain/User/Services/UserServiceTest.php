<?php

use App\Domain\User\Services\UserService;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;

describe('Unit: UserService', function () {

    it('can authenticate user when using authenticate method.', function () {
        // Arrange:
        $credentials = [
            'email' => 'email@test.com',
            'password' => 'password',
        ];

        $mock_token = new stdClass;
        $mock_token->plainTextToken = 'fake-token-value';
        $user = Mockery::mock(UserModel::class)->makePartial();

        $service = new UserService;

        // Expectation:
        Auth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andReturn(true);

        Auth::shouldReceive('user')->andReturn($user);

        $user->shouldReceive('createToken')
            ->with('API Token')
            ->andReturn($mock_token);

        // Act:
        $result = $service->authenticate($credentials);

        // Assert:
        expect($result)->toEqual($mock_token->plainTextToken);
    });

    it('can return failed authentication attempt when using authenticate method.', function () {
        // Arrange:
        $credentials = [
            'email' => 'email@test.com',
            'password' => 'password',
        ];

        $service = new UserService;

        // Expectation:
        Auth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andReturn(false);

        // Act:
        $result = $service->authenticate($credentials);

        // Assert:
        expect($result)->toBeFalse();
    });

});
