<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->type('[wire\\:model="data.email"]', 'nopal@gmail.com')
                    ->type('[wire\\:model="data.password"]', '12345678')
                    ->press('Masuk')
                    ->pause(3000)
                    ->assertPathIs('/admin');
        });
    }
}
