<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'devCarlos')
                    ->type('first_name', 'Carlos')
                    ->type('last_name', 'Developer')
                    ->type('email', 'carlos@gmail.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('@register-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated();

        });
    }

    /**
     * @test
     */
    public function user_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', '')
                    ->press('@register-btn')
                    ->assertPathIs('/register')
                    ->assertPresent('@validations-errors');

        });
    }
}
