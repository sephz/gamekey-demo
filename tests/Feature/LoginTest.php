<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_login()
    {
        $response = $this->post(route('api.v1.user.login'), [
            'email' => 'user@gmail.com',
            'password' => 'secret',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type'
            ]);
    }
}
