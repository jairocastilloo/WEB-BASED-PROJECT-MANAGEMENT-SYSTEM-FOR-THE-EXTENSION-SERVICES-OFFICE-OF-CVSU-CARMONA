<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminPrograms extends Migration
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
            $table->boolean('showOnlyMyUpcomingPrograms')->default(1);
            $table->boolean('showOnlyMyOverduePrograms')->default(1);
            $table->boolean('showOnlyMyCompletedPrograms')->default(1);
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
