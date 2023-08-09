<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Changeprojectcolumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['academicyear_id']);
        });

        // Remove academicyear_id column
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('academicyear_id');
        });

        // Add calendaryear_id as foreign key
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('calendaryear_id')->after('department');
            $table->foreign('calendaryear_id')->references('id')->on('calendar_years');
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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['calendaryear_id']);
        });

        // Revert: Remove added column and add back academicyear_id
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('academicyear_id')->after('department');
            $table->foreign('academicyear_id')->references('id')->on('academic_years');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('calendaryear_id');
        });
    }
}
