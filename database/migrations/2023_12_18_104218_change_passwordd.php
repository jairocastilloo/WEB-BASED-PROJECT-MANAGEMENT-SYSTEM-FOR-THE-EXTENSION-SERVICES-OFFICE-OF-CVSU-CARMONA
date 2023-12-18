<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePasswordd extends Migration
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