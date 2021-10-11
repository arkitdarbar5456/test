<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id');
            $table->integer('profile_id');
            $table->boolean('view_flag');
            $table->boolean('add_flag');
            $table->boolean('edit_flag');
            $table->boolean('delete_flag');
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
        Schema::dropIfExists('tbl_permissions');
    }
}
