<?php

use App\Models\User as UserModel;

describe('Feature: UserLoginController', function () {

    it('can authenticate user using /api/v1/user/login POST api endpoint..', function () {
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
