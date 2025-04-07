<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Query extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = ' add:query';
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
      //$query=$this->argument('query');
      $db=DB::table('users')->join('orders','users.id','=','orders.user_id')->get();
      $this->info('Success add query');
    }
}
