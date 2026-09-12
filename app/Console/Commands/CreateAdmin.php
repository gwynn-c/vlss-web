<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create
        {--name= : Display name}
        {--email= : Login email}
        {--password= : Login password}';

    protected $description = 'Create (or update) the admin user that manages site content';

    public function handle(): int
    {
        $name     = $this->option('name') ?: text('Name', default: 'Admin', required: true);
        $email    = $this->option('email') ?: text('Email', required: true);
        $password = $this->option('password') ?: password('Password', required: true);

        $validator = Validator::make(
            compact('name', 'email', 'password'),
            [
                'name'     => ['required', 'string', 'max:120'],
                'email'    => ['required', 'email', 'max:180'],
                'password' => ['required', 'string', 'min:8'],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password)],
        );

        $this->info(($user->wasRecentlyCreated ? 'Created' : 'Updated')." admin: {$user->email}");

        return self::SUCCESS;
    }
}
