<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActremarkToActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('actremark');
        });
        Schema::table('activities', function (Blueprint $table) {
            // Add the 'actremark' column as an enum with the allowed values
            $table->enum('actremark', ['Scheduled', 'In Progress', 'Pending', 'Overdue', 'Completed'])
                ->default('Scheduled');
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
