<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivityIdToSubtaskContributorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtask_contributor', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_id')->nullable()->after('user_id');

            // Add foreign key constraint to link the activity_id column with the activities table
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subtask_contributor', function (Blueprint $table) {
            // Drop the foreign key constraint first before removing the column
            $table->dropForeign(['activity_id']);
            $table->dropColumn('activity_id');
        });
    }
}
