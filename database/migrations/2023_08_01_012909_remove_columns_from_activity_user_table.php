<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromActivityUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_user', function (Blueprint $table) {
            // Drop the 'project_id' and 'assignees_name' columns
            $table->dropColumn('assignees_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_user', function (Blueprint $table) {
            // Reverse the migration (if needed)
            $table->string('assignees_name');
        });
    }
}
