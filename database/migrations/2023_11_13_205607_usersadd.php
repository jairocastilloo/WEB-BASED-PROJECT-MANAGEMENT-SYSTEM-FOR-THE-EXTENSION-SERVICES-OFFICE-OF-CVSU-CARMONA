<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usersadd extends Migration
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

            $table->text('bio')->nullable()->default(null);
            $table->string('social')->nullable()->default(null);
            $table->boolean('notifyInActivityDue')->default(0);
            $table->boolean('notifyInSubtaskDue')->default(0);
            $table->boolean('notifyInProjectDue')->default(0);
            $table->boolean('emailInvite')->default(0);
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
