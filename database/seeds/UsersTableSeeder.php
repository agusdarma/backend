<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
         'first_name' => 'admin',
         'last_name' => 'admin',
         'email' => 'admin@gmail.com',
         'phone_no' => '085693938630',
         'group_id' => '1',
         'gender' => 'male',
         'username' => 'admin',
         'status' => 'active',
         'password' => bcrypt('embadmin'),
       ]);
       DB::table('users')->insert([
        'first_name' => 'kasir',
        'last_name' => 'kasir',
        'email' => 'kasir@gmail.com',
        'phone_no' => '085693938631',
        'group_id' => '1',
        'gender' => 'femaile',
        'username' => 'kasir',
        'status' => 'active',
        'password' => bcrypt('embadmin'),
      ]);
    }
}
