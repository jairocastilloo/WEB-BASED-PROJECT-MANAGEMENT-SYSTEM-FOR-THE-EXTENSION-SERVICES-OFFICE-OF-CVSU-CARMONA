<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySubtaskContributorSubtaskIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtask_contributor', function (Blueprint $table) {
            $table->unsignedBigInteger('subtask_id')->nullable()->default(null)->change();
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
            $table->unsignedBigInteger('subtask_id')->nullable(false)->change();
        });
    }
}
