<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Asdzxc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projects', function (Blueprint $table) {
            // Drop the existing columns
            $table->dropColumn('projectleader');
            $table->dropColumn('programtitle');
            $table->dropColumn('programleader');
        });

        Schema::table('projects', function (Blueprint $table) {
            // Drop the existing columns
            $table->string('programtitle')->nullable()->after('projecttitle');
            $table->integer('projectleader')->nullable();

            $table->integer('programleader')->nullable();
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
