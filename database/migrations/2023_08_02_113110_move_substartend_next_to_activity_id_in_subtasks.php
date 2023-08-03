<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveSubstartendNextToActivityIdInSubtasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtasks', function (Blueprint $table) {
            // Remove the columns from their current position
            $table->dropColumn(['substartdate', 'subenddate']);
        });
        Schema::table('subtasks', function (Blueprint $table) {


            // Add the columns back with the desired position
            $table->date('substartdate')->nullable()->after('activity_id');
            $table->date('subenddate')->nullable()->after('substartdate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
