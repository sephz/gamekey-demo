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

    public function test_get_all_keys()
    {
        Sanctum::actingAs(
            User::find(2)
        );

        $response = $this->get(route('api.v1.gamekey.index'));

        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'key_id',
                    'game_title',
                    'description',
                    'key',
                    'price',
                    'currency',
                    'formatted_price',
                ]
            ]);
    }

    public function test_create_key()
    {
        Sanctum::actingAs(
            User::find(1)
        );

        $response = $this->post(route('api.v1.gamekey.store'), [
            'game_id' => 1,
            'key' => Str::random(20),
            'price' => 1000,
        ]);

        $response->assertOk();
    }
}
