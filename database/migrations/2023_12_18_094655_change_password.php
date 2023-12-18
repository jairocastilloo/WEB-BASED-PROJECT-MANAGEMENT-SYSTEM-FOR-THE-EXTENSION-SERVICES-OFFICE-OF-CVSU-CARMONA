<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePassword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('users', function ($table) {
            // Add a new temporary column to store the updated hashed passwords
            $table->string('new_password')->nullable();
        });

        // Update existing passwords to the desired value
        DB::table('users')->update(['new_password' => Hash::make('extensionpass!1')]);

        // Copy the new passwords to the original password column
        DB::table('users')->update(['password' => DB::raw('new_password')]);

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