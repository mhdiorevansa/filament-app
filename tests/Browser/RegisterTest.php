<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/register')
            ->type('[wire\\:model="data.name"]', 'abdel')
            ->type('[wire\\:model="data.email"]', 'abdel@gmail.com')
            ->type('[wire\\:model="data.password"]', 'password')
            ->type('[wire\\:model="data.passwordConfirmation"]', 'password')
            ->press('Buat akun')
            ->pause(3000)
            ->assertPathIs('/admin');
        });
    }
}
