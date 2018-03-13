<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class SystemSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_setting')->insert([
         'setting_desc' => 'Define how many times invalid login is allowed before user id is blocked',
         'setting_name' => 'MAX INVALID LOGIN',
         'setting_value' => '3',
         'updated_by' => '1',
       ]);
    }
}
