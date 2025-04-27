<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFilamentAdmin extends Command
{
    protected $signature = 'make:admin';
    protected $description = 'Create a new Filament admin user';

    public function handle()
    {
        $name = $this->ask('Name');
        $username = $this->ask('Username');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');
        
        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $this->info("Admin user {$name} created successfully!");
        
        return Command::SUCCESS;
    }
}