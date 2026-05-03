<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

describe('Site: Cash flow Index Page', function () {

    it('can render cash flow index page', function () {

        $user = User::factory()->create();

        $this->actingAs($user)->get('/cash_flow')
            ->assertInertia(fn (Assert $page) => $page
                ->component('pages/cash-flow/index')
            );
    });

});
