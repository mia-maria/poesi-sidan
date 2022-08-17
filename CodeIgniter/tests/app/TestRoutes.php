<?php

namespace App;

use CodeIgniter\Test\FeatureTestCase;

class TestRoutes extends FeatureTestCase {

    public function testStartpage(): void {

        $result = $this->call('get', '/');
        $result->assertOK();
        $result->assertSee('Välkommen till poesi-sidan');
    }

    public function testRegistrationPage(): void {

        $result = $this->call('get', '/user/registration');
        $result->assertOK();
        $result->assertSee('Registrera dig', 'h1');
        $result->assertSee('Bli medlem', 'button');
        $result->assertSee('Redan medlem? Logga in här!', 'a');
    }

    public function testLoginPage(): void {

        $result = $this->call('get', '/user/login');
        $result->assertOK();
        $result->assertSee('Logga in', 'h1');
        $result->assertSee('Logga in', 'button');
        $result->assertSee('Är du inte medlem? Registrera dig här!', 'a');
    }

    public function testInfoPage(): void {

        $_SESSION['logged_in'] = true;
        $result = $this->withSession()->get('/user/info');
        $result->assertOK();
        $result->assertSee('Användarvillkor', 'h2');
    }

    public function testInfoPage404(): void {

        $result = $this->call('get', '/user/info');
        $result->assertOK();
        $result->assertSee('404');
    }

    public function testLogoutPage(): void {

        $result = $this->call('get', '/user/logout');
        $result->assertOK();
        $result->assertSee('Vill du logga ut?', 'h1');
        $result->assertSee('Logga ut', 'button');
    }

    public function testLogoutMessage(): void {

        $result = $this->call('get', '/user/logoutMessage');
        $result->assertOK();
        $result->assertSee('Du har loggat ut. Välkommen tillbaka snart igen!', 'p');
    }

    public function testRemoveMember(): void {

        $_SESSION['logged_in'] = true;
        $result = $this->withSession()->get('/user/removeMember');
        $result->assertOK();
        $result->assertSee('Avsluta medlemskap', 'h2');
    }

    public function testRemoveMember403(): void {

        $result = $this->call('get', '/user/removeMember');
        $result->assertOK();
        $result->assertSee('403');
    }

    public function testGoodbyeMessage(): void {

        $result = $this->call('get', '/user/goodbyeMessage');
        $result->assertOK();
        $result->assertSee('Dina användaruppgifter och dikter är nu raderade. Tack för din tid som medlem på Poesi-sidan!', 'p');
    }

    public function testPoemsNew(): void {

        $result = $this->call('get', '/poems/new');
        $result->assertOK();
        $result->assertSee('Skapa en dikt!', 'h2');
        $result->assertSee('Publicera', 'button');
    }
}