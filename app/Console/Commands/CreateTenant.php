<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-tenant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter the name for the tenant:');
        $domain = $this->ask('Enter the domain for the tenant:');
        $username = $this->ask('Enter the username for the tenant:');
        $password = $this->secret('Enter the password for the tenant:');
        $user_id=$this->ask('Enter the user_id for the tenant:');
        $dbName = 'tenant_'.$username;
        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $username.'@gmail.com',
            'password' => bcrypt($password),
        ]);
        Tenant::create([
            'name' => $name,
            'user_id' => $user_id,
            'domain' => $domain,
            'database_name' => $dbName,
            'database_username' => $username,
            'database_password' => $password,
        ]);
        DB::statement("CREATE DATABASE $dbName");
        $this->info("Tenant {$domain} created successfully.");
    }
}
