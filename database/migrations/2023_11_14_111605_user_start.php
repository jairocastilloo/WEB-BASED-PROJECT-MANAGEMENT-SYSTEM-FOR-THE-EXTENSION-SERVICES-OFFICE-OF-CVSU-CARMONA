<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserStart extends Migration
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

            $table->dropColumn('emailSubtaskInvite');
            $table->dropColumn('emailActivityInvite');
            $table->dropColumn('emailProjectInvite');

            $table->dropColumn('notifyInSubtaskDue');
            $table->dropColumn('notifyInActivityDue');
            $table->dropColumn('notifyInProjectDue');
        });
        Schema::table("users", function (Blueprint $table) {



            $table->boolean('notifyInSubtaskDue')->default(1);
            $table->boolean('notifyInActivityDue')->default(1);
            $table->boolean('notifyInProjectDue')->default(1);

            $table->boolean('notifyInSubtaskToDo')->default(1);
            $table->boolean('notifyInActivityStart')->default(1);
            $table->boolean('notifyInProjectStart')->default(1);

            $table->boolean('notifySubtaskAdded')->default(1);
            $table->boolean('notifyActivityAdded')->default(1);
            $table->boolean('notifyProjectAdded')->default(1);

            $table->boolean('emailSubtaskAdded')->default(1);
            $table->boolean('emailActivityAdded')->default(1);
            $table->boolean('emailProjectAdded')->default(1);
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
