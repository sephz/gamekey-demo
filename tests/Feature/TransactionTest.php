<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    public function test_purchase()
    {
        Sanctum::actingAs(
            User::find(2)
        );

        $response = $this->post(route('api.v1.transaction.store'), [
            'key_id' => 1,
            'name' => 'ABC',
            'cc_number' => '4242424242424242',
            'cvc' => '123',
            'expiry' => '05-2025',
        ]);

        $response->assertOk();
    }
}
