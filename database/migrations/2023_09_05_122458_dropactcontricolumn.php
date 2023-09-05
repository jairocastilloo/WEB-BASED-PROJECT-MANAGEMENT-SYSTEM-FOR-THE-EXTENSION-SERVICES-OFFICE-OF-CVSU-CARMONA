<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Dropactcontricolumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('activity_contributions', function (Blueprint $table) {
            $table->dropColumn('approval');
        });
        Schema::table('activity_contributions', function (Blueprint $table) {
            $table->tinyInteger('approval')->nullable()->default(null)->after('hours_rendered');
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
