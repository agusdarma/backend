<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class UserLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_level')->insert([
         'level_name' => 'ROOT',
         'level_desc' => 'ROOT LEVEL',
         'updated_by' => '1',
         'created_by' => '1',
       ]);
    }
}
