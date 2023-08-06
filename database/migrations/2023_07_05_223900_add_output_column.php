<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOutputColumn extends Migration
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
            $table->unsignedBigInteger('project_id')->after('activity_id')->nullable();

            // Add foreign key constraint to project_id referencing the projects table
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::table('outputs', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['project_id']);

            // Drop the project_id column
            $table->dropColumn('project_id');
        });
    }
}
