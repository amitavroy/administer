<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('groups');

        Schema::create('groups', function($table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->comment('This is group name');
            $table->binary('data')->comment('User additional data is saved here');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }

}
