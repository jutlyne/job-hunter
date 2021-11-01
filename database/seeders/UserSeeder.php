<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'phone' => '0123456789',
            'phone_verified_at' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
            'password' => '123456',
        ]);
    }
}
