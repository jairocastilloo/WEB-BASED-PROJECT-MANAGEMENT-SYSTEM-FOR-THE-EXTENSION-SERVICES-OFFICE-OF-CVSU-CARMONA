<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'username' => 'admin',
            'middle_name' => 'eso',
            'last_name' => 'pms',
            'approval' => 1,
            'password' => Hash::make('qweqqweQ123'),
            'email' => 'vajairocastillo@gmail.com',
            'role' => 'Admin',
            'department' => 'Department of Industrial and Information Technology',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->where('email', 'vajairocastillo@gmail.com')->delete();
    }
}
