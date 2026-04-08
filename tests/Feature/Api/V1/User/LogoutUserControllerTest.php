<?php

use App\Application\User\UseCases\LogoutUser;
use App\Models\User as UserModel;
use Mockery\MockInterface;

describe('Feature: LogoutUserController', function () {

    describe('Positives', function () {

        it('can sign out authenticated user using /api/v1/user/logout POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Act:
            $response = $this->actingAs($user, 'web')->postJson('/api/v1/user/logout');

            // Assert:
            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'User logged out successfully.',
                ]);

            $this->assertGuest('web');
        });

    });

    describe('Negatives', function () {

        it('can handle server error response when using /api/v1/user/logout POST api endpoint.', function () {
            // Arrange:
            $user = UserModel::factory()->create();

            // Expectation:
            $this->mock(LogoutUser::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->andThrow(new Exception('This is a mock exception message.'));
            });

            // Act:
            $response = $this->actingAs($user)->postJson('/api/v1/user/logout');

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
