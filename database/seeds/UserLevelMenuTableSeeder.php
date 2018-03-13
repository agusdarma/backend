<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class UserLevelMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('user_level_menu')->insert([
           'level_id' => '1',
           'menu_id' => '1',
         ]);
         DB::table('user_level_menu')->insert([
          'level_id' => '1',
          'menu_id' => '101',
         ]);
         DB::table('user_level_menu')->insert([
           'level_id' => '1',
           'menu_id' => '102',
         ]);
         DB::table('user_level_menu')->insert([
          'level_id' => '1',
          'menu_id' => '103',
         ]);
         DB::table('user_level_menu')->insert([
          'level_id' => '1',
          'menu_id' => '104',
         ]);


    }
}
