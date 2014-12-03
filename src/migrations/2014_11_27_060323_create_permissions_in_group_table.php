<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsInGroupTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('group_permissions');

        Schema::create('group_permissions', function($table){
            $table->engine = 'InnoDB';
            $table->increments('gp_id');
            $table->integer('permission_id')->unsigned()->comment('The Permission id');
            $table->integer('group_id')->unsigned()->comment('The Group id');
            $table->boolean('allow')->comment('Whether the permission is given to this group or not');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_permissions');
    }

}
