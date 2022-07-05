<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'transaction_id' => (string) Str::uuid(),
            'key_id' => random_int(100,299),
            'key' => Str::random(20),
            'total_paid' => 1000,
            'commission' => 50,
            'cc_last' => '123',
            'cc_name' => 'Chew Kai Jun',
            'status' => 'COMPLETED',
            'paid_at' => Date::now(),
        ];
    }
}
