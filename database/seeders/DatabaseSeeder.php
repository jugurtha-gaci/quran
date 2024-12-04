<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'subscription_price' => 49.99,
        ]);
        $group = Group::create([
            'name' => 'A',
            'max_members' => 25
        ]);
        User::create([
            'email' => 'dalila@gmail.com',
            'fullName' => 'dalila zeghmiche',
            'password' => Hash::make('dalila2004'),
            'admin' => 1,
            'group_id' => $group->id
        ]);
    }
}
