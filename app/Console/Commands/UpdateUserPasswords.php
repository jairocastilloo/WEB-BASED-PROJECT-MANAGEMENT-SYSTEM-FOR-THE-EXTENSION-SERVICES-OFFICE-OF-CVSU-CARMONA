<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Import your User model

class UpdateUserPasswords extends Command
{
    protected $signature = 'update:user-passwords';
    protected $description = 'Update passwords for users with approval = 1';

    public function handle()
    {
        $this->info('Generating and updating passwords...');

        // Fetch users with approval = 1
        $users = User::where('approval', 1)->get();

        // Update passwords and display information
        foreach ($users as $user) {

                // Generate a password with "extensionpass" and a random 4-digit number
                $generatedPassword = $this->generatePassword();

                // Display information about the user
                $this->line("Username: {$user->username}, Email: {$user->email}");
                $this->line("Generated Password: {$generatedPassword}");

                // Update the password
                $user->password = Hash::make($generatedPassword);
                $user->save();

        }

        $this->info('User passwords updated successfully.');
    }

    /**
     * Generate a password with "extensionpass" and a random 4-digit number.
     *
     * @return string
     */
    private function generatePassword()
    {
        $basePassword = 'extensionpass';
        $randomNumber = mt_rand(1000, 9999);

        return $basePassword . $randomNumber;
    }
}