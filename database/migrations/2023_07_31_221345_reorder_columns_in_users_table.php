<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReorderColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['middle_name', 'last_name', 'approval']);
        });

        // Re-add the columns in the desired order
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->smallInteger('approval')->default(0)->after('last_name');
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
