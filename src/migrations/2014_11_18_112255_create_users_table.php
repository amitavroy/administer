<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('users');

        Schema::create('users', function($table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name')->comment('This is used as display name');
                $table->string('email')->unique()->comment('This is username');
                $table->string('password');
                $table->string('type')->default('normal');
                $table->timestamps();
                $table->string('timezone')->default('Asia/Kolkata');
                $table->binary('data');
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
