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
         'menu_id' => '1',
         'parent_id' => '1',
         'menu_root_id' => '1',
         'menu_level' => '1',
         'show_order' => '1',
         'menu_leaf' => '0',
         'menu_description' => 'Security',
         'menu_url' => '',
         'menu_icon' => 'fa fa-key',
         'menu_group' => 'Security',
         'always_include' => '0',
       ]);
       DB::table('user_menu')->insert([
        'menu_id' => '101',
        'parent_id' => '1',
        'menu_root_id' => '1',
        'menu_level' => '2',
        'show_order' => '3',
        'menu_leaf' => '1',
        'menu_description' => 'User Level',
        'menu_url' => 'UserLevel',
        'menu_icon' => 'fa fa-level-up',
        'menu_group' => 'Security',
        'always_include' => '0',
      ]);
      DB::table('user_menu')->insert([
       'menu_id' => '102',
       'parent_id' => '1',
       'menu_root_id' => '1',
       'menu_level' => '2',
       'show_order' => '1',
       'menu_leaf' => '1',
       'menu_description' => 'Add User Data',
       'menu_url' => 'UserData',
       'menu_icon' => 'fa fa-user',
       'menu_group' => 'Security',
       'always_include' => '0',
     ]);
     DB::table('user_menu')->insert([
      'menu_id' => '103',
      'parent_id' => '1',
      'menu_root_id' => '1',
      'menu_level' => '2',
      'show_order' => '3',
      'menu_leaf' => '1',
      'menu_description' => 'Change Password',
      'menu_url' => 'ChangePassword',
      'menu_icon' => 'fa fa-lock',
      'menu_group' => 'Security',
      'always_include' => '1',
    ]);
    DB::table('user_menu')->insert([
     'menu_id' => '104',
     'parent_id' => '1',
     'menu_root_id' => '1',
     'menu_level' => '2',
     'show_order' => '5',
     'menu_leaf' => '1',
     'menu_description' => 'Reset Password',
     'menu_url' => 'ResetPassword',
     'menu_icon' => 'fa fa-unlock',
     'menu_group' => 'Security',
     'always_include' => '0',
   ]);
     DB::table('user_menu')->insert([
      'menu_id' => '105',
      'parent_id' => '1',
      'menu_root_id' => '1',
      'menu_level' => '2',
      'show_order' => '2',
      'menu_leaf' => '1',
      'menu_description' => 'View User Data',
      'menu_url' => 'UserData/view',
      'menu_icon' => 'fa fa-list',
      'menu_group' => 'Security',
      'always_include' => '0',
    ]);
     DB::table('user_menu')->insert([
      'menu_id' => '2',
      'parent_id' => '2',
      'menu_root_id' => '2',
      'menu_level' => '1',
      'show_order' => '2',
      'menu_leaf' => '0',
      'menu_description' => 'Settings',
      'menu_url' => '',
      'menu_icon' => 'fa fa-cog',
      'menu_group' => 'Settings',
      'always_include' => '0',
    ]);
      DB::table('user_menu')->insert([
       'menu_id' => '201',
       'parent_id' => '2',
       'menu_root_id' => '2',
       'menu_level' => '2',
       'show_order' => '1',
       'menu_leaf' => '1',
       'menu_description' => 'System Setting',
       'menu_url' => 'SysSetting',
       'menu_icon' => 'fa fa-cogs',
       'menu_group' => 'Settings',
       'always_include' => '0',
     ]);

    }
}
