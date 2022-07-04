<?php

namespace Tests\Unit;

use App\Models\Key;
use PHPUnit\Framework\TestCase;

class GameKeyTest extends TestCase
{

    /** @test */
    public function test_get_key_price_in_dollars()
    {
        $key = Key::factory()->make([
            'price' => 10000,
        ]);

        $this->assertSame('100.00', $key->formatted_price);
    }
}
