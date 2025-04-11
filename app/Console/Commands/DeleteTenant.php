<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-tenant';

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
        $username = $this->ask('Enter the username of the tenant to migrate:');
        $user = User::where('username', $username)->first();
        $tenant = Tenant::where('user_id', $user->id)->first();
        if (!$tenant) {
            $this->error("Tenant {$username} not found.");
            return;
        }
        DB::statement("DROP DATABASE {$tenant->database_name}");
        $tenant->delete();
        $this->info("Tenant {$username} deleted successfully.");
    }
}
