<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnevaluatedToEndRemarksColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('subtasks', function (Blueprint $table) {
            $table->dropColumn('endRemarks');
        });
        Schema::table('subtasks', function (Blueprint $table) {
            $table->enum('endRemarks', ['Upcoming', 'Missing', 'Done', 'Unevaluated'])->default('Upcoming');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
