<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
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
         'invalid_count' => '0',
         'gender' => 'male',
         'username' => 'admin',
         'status' => 'active',
         'created_by' => '1',
         'updated_by' => '1',
         'password' => Crypt::encryptString('embadmin'),
       ]);
       DB::table('users')->insert([
        'first_name' => 'kasir',
        'last_name' => 'kasir',
        'email' => 'kasir@gmail.com',
        'phone_no' => '085693938631',
        'group_id' => '1',
        'invalid_count' => '0',
        'gender' => 'femaile',
        'username' => 'kasir',
        'status' => 'active',
        'created_by' => '1',
        'updated_by' => '1',
        'password' => Crypt::encryptString('embadmin'),
      ]);
    }
}
