<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    public function test_register_function_success()
    {
        $this->browse(function (Browser $browser) {
           $browser->visit(env('APP_URL') . '/register')
               ->type('name', 'Test')
               ->type('email', 'testview@example.com')
               ->type('password', 'test')
               ->type('password_confirmation', 'test')
               ->type('address', 'Ha Noi')
               ->type('phone', '0123456789')
               ->press('#register')
               ->assertPathIs('/login');
        });
    }

    public function test_register_function_fail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/register')
                ->type('name', 'Test')
                ->type('email', 'testview@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'notconfirm')
                ->type('address', 'Ha Noi')
                ->type('phone', '0123456789')
                ->press('#register')
                ->assertPathIs('/register');
        });
    }

    public function test_return_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/register')
                ->press('#return-login')
                ->assertPathIs('/login');
        });
    }
}
