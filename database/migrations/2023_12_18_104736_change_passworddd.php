<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePassworddd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {


        // Drop the temporary column
        Schema::table('users', function ($table) {
            $table->dropColumn('new_password');
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