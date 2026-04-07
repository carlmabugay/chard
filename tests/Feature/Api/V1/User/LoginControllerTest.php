<?php

use App\Application\User\UseCases\AuthenticateUser;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: UserLoginController', function () {

    describe('Positives', function () {

        it('can authenticate user using /api/v1/user/login POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'email' => $user->email,
                'password' => 'password',
            ];

            // Act:
            $response = $this->post('/api/v1/user/login', $payload);

            // Assert:
            $response->assertStatus(200);
            $this->assertAuthenticated();
        });

    });

    describe('Negatives', function () {

        it('can return invalid credentials using /api/v1/user/login POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'email' => $user->email,
                'password' => 'wrong_password',
            ];

            // Act:
            $response = $this->post('/api/v1/user/login', $payload);

            // Assert:
            $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Invalid login credentials.',
                ]);
        });

        it('can handle server error response when using /api/v1/user/login POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'email' => $user->email,
                'password' => 'password',
            ];

            // Expectation:
            $this->mock(AuthenticateUser::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $response = $this->post('/api/v1/user/login', $payload);

            // Assert:
            $response->assertInternalServerError()
                ->assertJson([
                    'success' => false,
                    'error' => 'An unexpected error occurred. Please try again later.',
                    'message' => 'This is a mock exception message.',
                ]);
        });

    });

});
