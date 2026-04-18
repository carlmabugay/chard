<?php

use App\Application\User\UseCases\AuthenticateUser;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: LoginUserController', function () {

    describe('Positives', function () {

        it('can authenticate user using /api/v1/user/login POST api endpoint or /login POST web endpoint.', function (string $route) {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'email' => $user->email,
                'password' => 'password',
            ];

            // Act:
            $response = $this->postJson($route, $payload);

            // Assert:
            $response->assertOk();
            $this->assertAuthenticated();
        });

    });

    describe('Negatives', function () {

        it('can return invalid credentials using /api/v1/user/login POST api endpoint or /login POST web endpoint.', function ($route) {
            // Arrange:
            $user = UserModel::factory()->create();

            $payload = [
                'email' => $user->email,
                'password' => 'wrong_password',
            ];

            // Act:
            $response = $this->postJson($route, $payload);

            // Assert:
            $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Invalid login credentials.',
                ]);

            $this->assertGuest();
        });

        it('can handle server error response when using /api/v1/user/login POST api endpoint or /login POST web endpoint.', function (string $route) {
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
            $response = $this->postJson($route, $payload);

            // Assert:
            $response->assertInternalServerError()
                ->assertJson([
                    'success' => false,
                    'error' => 'An unexpected error occurred. Please try again later.',
                    'message' => 'This is a mock exception message.',
                ]);
        });
    });

    describe('Validation', function () {

        it('requires email and password fields when using /api/v1/user/login POST api endpoint.', function (string $route) {
            // Arrange:

            // Act:
            $response = $this->postJson($route, []);

            // Assert:
            $response->assertStatus(422)
                ->assertJson([
                    'errors' => [
                        'email' => [
                            0 => __('validation.required', ['attribute' => 'email']),
                        ],
                        'password' => [
                            0 => __('validation.required', ['attribute' => 'password']),
                        ],
                    ],
                ]);
        });

    });

})->with(['/api/v1/user/login', '/login']);
