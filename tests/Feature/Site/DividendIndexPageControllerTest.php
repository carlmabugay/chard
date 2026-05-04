<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

describe('Site: Dividend Index Page', function () {

    it('can render dividend index page', function () {

        $user = User::factory()->create();

        $this->actingAs($user)->get('/dividend')
            ->assertInertia(fn (Assert $page) => $page
                ->component('dividend/index')
            );
    });

});
