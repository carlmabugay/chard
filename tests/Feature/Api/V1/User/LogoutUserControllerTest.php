<?php

use App\Application\User\UseCases\LogoutUser;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: LogoutUserController', function () {

    describe('Positives', function () {

        it('can sign out authenticated user using /api/v1/user/login POST api endpoint or /login POST web endpoint.', function (?string $guard, string $route) {
            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            $response = $this->actingAs($user, $guard)->postJson($route);

            // Assert:
            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'User logged out successfully.',
                ]);

            $this->assertGuest($guard);
        });

    });

    describe('Negatives', function () {

        it('can return unauthenticated message when trying to access protected /api/v1/user/logout POST api endpoint or /logout POST web endpoint.', function (string $guard, string $route) {
            // Arrange:

            // Act:
            $response = $this->postJson($route);

            // Assert:
            $response->assertUnauthorized()
                ->assertExactJson([
                    'success' => false,
                    'message' => __('messages.unauthenticated'),
                ]);
        });

        it('can handle server error response when using /api/v1/user/logout POST api endpoint or /logout POST web endpoint.', function (string $guard, string $route) {
            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(LogoutUser::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->postJson($route);

            // Assert:
            $response->assertInternalServerError()
                ->assertJson([
                    'success' => false,
                    'error' => 'An unexpected error occurred. Please try again later.',
                    'message' => 'This is a mock exception message.',
                ]);
        });

    });

})->with([
    ['sanctum', '/api/v1/user/logout'],
    ['web', '/logout'],
]);
