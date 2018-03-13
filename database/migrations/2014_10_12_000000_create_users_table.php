<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name','64')->nullable();
            $table->string('last_name','64')->nullable();
            $table->string('email','128')->unique();
            $table->string('phone_no','32')->unique();
            $table->integer('group_id')->nullable();
            $table->integer('invalid_count')->default('0');
            $table->string('gender','16')->nullable();
            $table->string('username','64')->nullable();
            $table->string('password','256');
            $table->string('status','32');
            $table->string('store','32')->nullable();
            $table->string('remember_token','100')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->useCurrent();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}
