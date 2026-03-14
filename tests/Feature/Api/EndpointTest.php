<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('returns a successful response', function () {

    Sanctum::actingAs(
        User::factory()->create()
    );

    $response = $this->get('/api/user');

    $response->assertOk();

});
