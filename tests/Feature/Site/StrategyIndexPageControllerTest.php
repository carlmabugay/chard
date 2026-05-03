<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

describe('Site: Strategy Index Page', function () {

    it('can render strategy index page', function () {

        $user = User::factory()->create();

        $this->actingAs($user)->get('/strategy')
            ->assertInertia(fn (Assert $page) => $page
                ->component('strategy/index')
            );
    });

});
