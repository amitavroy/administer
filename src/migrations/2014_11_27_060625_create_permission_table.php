<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('permissions');

        Schema::create('permissions', function($table){
            $table->engine = 'InnoDB';
            $table->increments('permission_id');
            $table->string('permission_name', 100);
            $table->string('permission_machine_name', 100);
            $table->string('permission_group', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }

}
