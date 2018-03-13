<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('system_setting', function (Blueprint $table) {
          $table->increments('id');
          $table->string('setting_desc','200');
          $table->string('setting_name','64');
          $table->string('setting_value','255');
          $table->timestamp('updated_at')->useCurrent();
          $table->integer('updated_by');
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
