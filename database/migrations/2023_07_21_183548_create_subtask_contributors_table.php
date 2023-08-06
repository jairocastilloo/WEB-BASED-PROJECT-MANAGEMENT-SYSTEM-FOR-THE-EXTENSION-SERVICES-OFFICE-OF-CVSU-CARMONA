<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtaskContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtask_contributor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subtask_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('hours_rendered')->default(0);
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('subtask_id')->references('id')->on('subtasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtask_contributor');
    }
}
