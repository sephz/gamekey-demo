<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $merchant = User::create([
            'type' => User::TYPE_MERCHANT,
            'name' => 'I am Merchant',
            'email' => 'merchant@gmail.com',
            'password' => 'secret',
            'email_verified_at' => now(),
            'active' => true,
        ]);

        User::create([
            'type' => User::TYPE_USER,
            'name' => 'I am User',
            'email' => 'user@gmail.com',
            'password' => 'secret',
            'email_verified_at' => now(),
            'active' => true,
        ]);

        Merchant::create([
            'user_id' => $merchant->id,
            'name' => 'BlackStone Inc.',
            'callback_url' => 'http://localhost/api/test-callback',
            'secret' => 'E47WUt2ZQncDPZKjebqNzca26Jgsh3YV',
            'active' => true,
        ]);
    }
}
