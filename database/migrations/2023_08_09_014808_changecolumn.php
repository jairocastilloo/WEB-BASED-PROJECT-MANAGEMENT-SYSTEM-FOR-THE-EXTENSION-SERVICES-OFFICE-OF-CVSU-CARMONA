<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Changecolumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('calendar_years', function (Blueprint $table) {
            $table->dropColumn(['calendarstartdate', 'calendarenddate']);
        });

        // Add years in the calendar_years table
        Schema::table('calendar_years', function (Blueprint $table) {
            $table->integer('year')->unique();
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
