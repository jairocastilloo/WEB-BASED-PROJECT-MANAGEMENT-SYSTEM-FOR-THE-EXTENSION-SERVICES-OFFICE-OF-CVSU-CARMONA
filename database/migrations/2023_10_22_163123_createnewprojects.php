<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createnewprojects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop the existing columns
            $table->string('programtitle')->nullable()->after('projecttitle');
            $table->integer('projectleader')->nullable();

            $table->integer('programleader')->nullable();
        });
        // Add new nullable columns with the desired data types

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
