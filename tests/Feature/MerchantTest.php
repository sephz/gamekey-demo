<?php

namespace Tests\Feature;

use App\Models\Merchant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MerchantTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_merchant()
    {
        $merchant = Merchant::factory()->create();

        $merchants = Merchant::get();

        $this->assertTrue($merchants->contains($merchant));
    }
}
