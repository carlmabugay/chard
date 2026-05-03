<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

describe('Site: Portfolio Index Page', function () {

    it('can render portfolio index page', function () {

        $user = User::factory()->create();

        $this->actingAs($user)->get('/portfolio')
            ->assertInertia(fn (Assert $page) => $page
                ->component('portfolio/index')
            );
    });

});
