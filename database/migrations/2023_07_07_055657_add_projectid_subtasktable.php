<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectidSubtasktable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('outputs', function (Blueprint $table) {
            $table->integer('output_submitted')->default(0)->change();
        });
        Schema::table('subtasks', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->after('activity_id');
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
        Schema::table('subtasks', function (Blueprint $table) {
            $table->dropColumn('project_id');
        });
        Schema::table('outputs', function (Blueprint $table) {
            $table->boolean('output_submitted')->default(false)->change();
        });
    }
}
