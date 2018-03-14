<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_menu', function (Blueprint $table) {
          $table->integer('menu_id');
          $table->integer('parent_id');
          $table->integer('menu_root_id');
          $table->integer('menu_level');
          $table->integer('show_order');
          $table->integer('menu_leaf');
          $table->string('menu_description','500');
          $table->string('menu_url','100');
          $table->string('menu_icon','100');
          $table->string('menu_group','40');
          $table->integer('always_include');
          $table->engine = 'InnoDB';
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
