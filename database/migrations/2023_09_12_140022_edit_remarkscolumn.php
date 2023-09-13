<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditRemarkscolumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('subtasks', function (Blueprint $table) {
            $table->dropColumn('endRemarks');
        });
        Schema::table('subtasks', function (Blueprint $table) {
            $table->enum('status', ['Completed', 'Incomplete'])->default('Incomplete');
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
