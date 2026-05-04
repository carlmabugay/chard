<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

describe('Site: Trade Log Index Page', function () {

    it('can render trade log index page', function () {

        $user = User::factory()->create();

        $this->actingAs($user)->get('/trade_log')
            ->assertInertia(fn (Assert $page) => $page
                ->component('trade-log/index')
            );
    });

});
