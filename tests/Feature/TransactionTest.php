<?php

namespace Tests\Feature;

use App\Jobs\TransactionCallback;
use App\Mail\OrderConfirmationEmail;
use App\Models\Key;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    public function test_purchase()
    {
        Sanctum::actingAs(
            User::find(2)
        );

        Mail::fake();

        Bus::fake();

        $key = Key::factory()->create();

        $response = $this->post(route('api.v1.transaction.store'), [
            'key_id' => $key->id,
            'name' => 'Chew Kai Jun ',
            'cc_number' => '4242424242424242',
            'cvc' => '123',
            'expiry' => '05-2025',
        ]);

        Bus::assertDispatched(TransactionCallback::class);

        Mail::assertSent(OrderConfirmationEmail::class);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => true,
                'transaction_id' => true,
            ]);;
    }
}
