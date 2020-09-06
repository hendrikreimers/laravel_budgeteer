<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        // Creates the first User as admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@' . config('app.host'),
            'password' => Hash::make('budget'),
            'remember_token' => str_random(10),
            'role_id' => 1
        ]);

        // Creates the first User as admin
        User::create([
            'name' => 'User',
            'email' => 'user@' . config('app.host'),
            'password' => Hash::make('budget'),
            'remember_token' => str_random(10),
            'role_id' => 3,
            'disabled' => true
        ]);
    }
}
