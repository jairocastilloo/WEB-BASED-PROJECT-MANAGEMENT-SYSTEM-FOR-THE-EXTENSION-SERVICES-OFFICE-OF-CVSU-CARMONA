<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutputUserTable extends Migration
{
    public function up()
    {
        Schema::create('output_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('output_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('output_id')->references('id')->on('outputs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('output_user');
    }
}
