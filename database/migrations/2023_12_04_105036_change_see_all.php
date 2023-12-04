<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSeeAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn('showOnlyMyProjects');
            $table->dropColumn('showOnlyMySubtasks');
            $table->dropColumn('showOnlyMyActivities');
        });
        Schema::table("users", function (Blueprint $table) {
            $table->boolean('showOnlyMyActiveTasks')->default(1);
            $table->boolean('showOnlyMyOverdueTasks')->default(1);
            $table->boolean('showOnlyMyCompletedTasks')->default(1);
            $table->boolean('showOnlyMyOngoingActivities')->default(1);
            $table->boolean('showOnlyMyUpcomingActivities')->default(1);
            $table->boolean('showOnlyMyOverdueActivities')->default(1);
            $table->boolean('showOnlyMyCompletedActivities')->default(1);
            $table->boolean('showOnlyMyOngoingProjects')->default(1);
            $table->boolean('showOnlyMyUpcomingProjects')->default(1);
            $table->boolean('showOnlyMyOverdueProjects')->default(1);
            $table->boolean('showOnlyMyCompletedProjects')->default(1);
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
