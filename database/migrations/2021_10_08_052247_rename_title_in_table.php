<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTitleInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_photos', function (Blueprint $table) {
            //
             $table->renameColumn('title', 'file');
        });

        Schema::table('tbl_status_reports', function (Blueprint $table) {
            //
             $table->renameColumn('title', 'file');
        });

        Schema::table('tbl_quotations', function (Blueprint $table) {
            //
             $table->renameColumn('title', 'file');
        });

        Schema::table('tbl_notes', function (Blueprint $table) {
            //
             $table->renameColumn('title', 'file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_photos', function (Blueprint $table) {
            //
            $table->renameColumn('file', 'title');
        });

        Schema::table('tbl_status_reports', function (Blueprint $table) {
            //
             $table->renameColumn('title', 'file');
        });

        Schema::table('tbl_quotations', function (Blueprint $table) {
            //
             $table->renameColumn('title', 'file');
        });

        Schema::table('tbl_notes', function (Blueprint $table) {
            //
             $table->renameColumn('title', 'file');
        });
    }
}
