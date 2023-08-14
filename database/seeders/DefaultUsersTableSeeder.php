<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert(
                [
                    /** 初期管理者 */
                    [
                        'name' => 'システム管理者',
                        'email' => '',
                        'userid' => 'admin',
                        // change to laravel6.
                        // 'password' => bcrypt('C-admin'),
                        'password' => Hash::make('C-admin'),
                        'columns_set_id' => 1,
                        'remember_token' => '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                ]
            );
        }
    }
}
