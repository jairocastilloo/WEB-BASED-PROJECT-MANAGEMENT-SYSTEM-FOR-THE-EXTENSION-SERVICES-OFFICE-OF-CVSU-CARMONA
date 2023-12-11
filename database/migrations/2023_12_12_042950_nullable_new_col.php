<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableNewCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table("contributions", function (Blueprint $table) {
            $table->string('relatedPrograms')->nullable()->change();
            $table->integer('clientNumbers')->nullable()->change();
            $table->string('agency')->nullable()->change();
        });
         Schema::table("activity_contributions", function (Blueprint $table) {
            $table->string('relatedPrograms')->nullable()->change();
            $table->integer('clientNumbers')->nullable()->change();
            $table->string('agency')->nullable()->change();
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