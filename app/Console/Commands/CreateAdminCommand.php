<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Let’s create a new admin account!');
        $this->line('--------------------------------');

        $data = [
            'name'     => $this->ask('Enter admin name'),
            'email'    => $this->ask('Enter admin email'),
            'password' => $this->secret('Enter password'),
            'confirm'  => $this->secret('Confirm password'),
        ];

        $validator = Validator::make($data, [
            'name'     => 'required|string|min:3|max:50',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
            'confirm'  => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $this->error('❌ Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->line(" - {$error}");
            }
            return Command::FAILURE;
        }

        $admin = Admin::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password']
        ]);

        $this->info('✅ Admin created successfully!');
        $this->line("Name: {$admin->name}");
        $this->line("Email: {$admin->email}");

        return Command::SUCCESS;
    }
}
