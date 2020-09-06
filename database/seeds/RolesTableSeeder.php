<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        // Creates the first User as admin
        Role::create([
            'name' => 'Admin',
            'read_only' => true,

            'user_view' => true,
            'user_list' => true,
            'user_create' => true,
            'user_update' => true,
            'user_delete' => true,

            'role_view' => true,
            'role_list' => true,
            'role_create' => true,
            'role_update' => true,
            'role_delete' => true,

            'subject_view' => true,
            'subject_list' => true,
            'subject_create' => true,
            'subject_update' => true,
            'subject_delete' => true,
            'subject_globals' => true,

            'account_view' => true,
            'account_list' => true,
            'account_create' => true,
            'account_update' => true,
            'account_delete' => true,
            'account_globals' => true,

            'receipt_view' => true,
            'receipt_list' => true,
            'receipt_create' => true,
            'receipt_update' => true,
            'receipt_delete' => true
        ]);

        Role::create([
            'name' => 'Editor',
            'read_only' => false,

            'subject_list' => true,
            'subject_create' => true,
            'subject_update' => true,
            'subject_delete' => true,
            'subject_globals' => true,

            'account_list' => true,
            'account_create' => true,
            'account_update' => true,
            'account_delete' => true,
            'account_globals' => true
        ]);

        Role::create([
            'name' => 'User',
            'read_only' => false
        ]);
    }
}
