<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_level', function (Blueprint $table) {
          $table->increments('id');
          $table->string('level_name','100');
          $table->string('level_desc','250');
          $table->timestamp('updated_at')->useCurrent();
          $table->integer('updated_by');
          $table->timestamp('created_at')->useCurrent();
          $table->integer('created_by');
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
