<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchant>
 */
class MerchantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => Str::random(40),
            'callback_url' => 'http://localhost/api/test-callback',
            'secret' => 'E47WUt2ZQncDPZKjebqNzca26Jgsh3YV',
        ];
    }
}
