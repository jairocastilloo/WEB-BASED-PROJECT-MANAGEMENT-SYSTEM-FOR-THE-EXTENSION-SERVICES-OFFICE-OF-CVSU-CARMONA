<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnAcademicyears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('academic_years', function (Blueprint $table) {
            $table->date('firstsem_startdate')->after('acadenddate');
            $table->date('firstsem_enddate')->after('firstsem_startdate');
            $table->date('secondsem_firstdate')->after('firstsem_enddate');
            $table->date('secondsem_enddate')->after('secondsem_firstdate');
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
