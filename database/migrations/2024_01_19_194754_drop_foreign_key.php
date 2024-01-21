<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table("program_leaders", function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['project_id']);

            // Now drop the column and add the new foreign key
            $table->dropColumn('project_id');
        });

        Schema::table("program_leaders", function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->foreignId('program_id')->constrained();
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
    }
}
