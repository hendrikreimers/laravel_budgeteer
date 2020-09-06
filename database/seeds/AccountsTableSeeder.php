<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Account;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->delete();

        Account::create([
            'user_id' => 1,
            'is_global' => 1,
            'name' => 'Bank'
        ]);

        Account::create([
            'user_id' => 1,
            'is_global' => 1,
            'name' => 'Kasse'
        ]);
    }
}
