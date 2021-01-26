<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUser extends Command
{
    protected $signature = 'make:user';

    public function handle()
    {
        $email = $this->ask('email?');
        $first_name = $this->ask('first name?');
        $last_name = $this->ask('last name?');
        $password = $this->ask('password?');

        User::create([
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'password' => Hash::make($password),
        ]);

        $this->comment('User created.');

        return 0;
    }
}
