<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameOutputSubmittedColumn extends Migration
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
            $table->renameColumn('output_submitted', 'totaloutput_submitted');
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
            $table->renameColumn('totaloutput_submitted', 'output_submitted');
        });
    }
}
