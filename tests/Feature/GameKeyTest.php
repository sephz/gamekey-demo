<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GameKeyTest extends TestCase
{

    public function test_create_key_example()
    {
        Sanctum::actingAs(
            User::find(1)
        );

        $response = $this->post(route('api.v1.gamekey.store'), [
            'game_id' => 1,
            'key' => Str::random(20),
            'price' => 1000,
        ]);

        dd($response->getContent());

        $response->assertOk();
    }
}
