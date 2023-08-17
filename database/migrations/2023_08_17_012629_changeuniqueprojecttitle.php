<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Changeuniqueprojecttitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique('projects_projecttitle_unique');
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
        Schema::table('projects', function (Blueprint $table) {
            // Re-add the unique constraint on the projecttitle column
            $table->unique('projecttitle');

            // Change the data type of the projecttitle column back to its original type
            // You'll need to provide the original data type here (e.g., varchar)
            // $table->varchar('projecttitle')->change();
        });
    }
}
