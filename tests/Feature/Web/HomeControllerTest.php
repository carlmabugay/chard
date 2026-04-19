<?php

use Inertia\Testing\AssertableInertia as Assert;

describe('HomeControllerTest', function () {

    it('can render Home page', function () {

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
            );
    });

});
