<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeMiddlenameUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("UPDATE users SET middle_name = '' WHERE middle_name IS NULL");

        // Modify the column definition to disallow NULL values
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable(false)->change();
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
        DB::statement("UPDATE users SET middle_name = NULL WHERE middle_name = ''");

        // Modify the column definition to allow NULL values
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->change();
        });
    }
}
