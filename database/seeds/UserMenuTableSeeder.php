<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class UserMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_menu')->insert([
         'menu_id' => 'ROOT',
         'parent_id' => 'ROOT LEVEL',
         'menu_root_id' => '1',
         'menu_level' => '1',
       ]);
    }
}
