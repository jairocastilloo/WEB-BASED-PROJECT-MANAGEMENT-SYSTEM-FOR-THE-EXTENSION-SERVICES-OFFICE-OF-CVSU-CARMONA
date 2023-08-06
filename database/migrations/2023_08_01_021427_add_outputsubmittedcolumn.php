<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOutputsubmittedcolumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('output_user', function (Blueprint $table) {
            // Add the 'approval' column with a default value of 0
            // Restrict the column values to 1 and 0
            $table->integer('output_submitted')->default(0);
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
        Schema::table('output_user', function (Blueprint $table) {
            // Drop the 'approval' column if you ever want to rollback
            $table->dropColumn('approval');
        });
    }
}
