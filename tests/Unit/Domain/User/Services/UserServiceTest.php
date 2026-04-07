<?php

use App\Domain\User\Services\UserService;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

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

    it('can sign out authenticated user when using logout method.', function () {
        // Arrange:
        $mock_request = Request::create('api/v1/user/logout', 'POST');
        $mock_session = Mockery::mock(Store::class);
        $mock_token = Mockery::mock(PersonalAccessToken::class);
        $mock_user = Mockery::mock(UserModel::class);

        $service = new UserService;

        // Expectation:
        $mock_token->shouldReceive('delete')->once();
        $mock_user->shouldReceive('currentAccessToken')->andReturn($mock_token);

        Auth::shouldReceive('user')->andReturn($mock_user);
        Auth::shouldReceive('guard')->with('web')->andReturnSelf();
        Auth::shouldReceive('logout')->once();
        $mock_session->shouldReceive('invalidate')->once();
        $mock_session->shouldReceive('regenerateToken')->once();

        $mock_request->setLaravelSession($mock_session);
        $mock_request->setUserResolver(fn () => $mock_user);

        // Act:
        $service->logout($mock_request);

        // Assert:
    });

});
