<?php

namespace Tests\Feature;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\User;


class GameTest extends TestCase
{

    use WithFaker;

    public function test_create_game()
    {

        Sanctum::actingAs(
            User::find(1)
        );

        $response = $this->post(route('api.v1.game.store'), [
            'title' => 'GAME 1',
            'description' => $this->faker->text(),
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'title',
                'description',
            ]);

    }

    public function test_get_game()
    {

        Sanctum::actingAs(
            User::find(1)
        );

        $response = $this->get(route('api.v1.game.show',['game'=>1]));

        $response->assertOk()
            ->assertJsonStructure([
                'id',
                'title',
                'description',
            ]);

    }
}
