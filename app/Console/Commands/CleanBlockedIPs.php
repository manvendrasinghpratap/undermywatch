<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ips;
use App\Ipsv6;
use Carbon\Carbon;

class CleanBlockedIPs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockedip:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Old Temporary Blocked IPs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        if(Ips::whereis_permanent(0)->where('updated_at', '<', Carbon::now()->subHours(3)->toDateTimeString())->where('repetition', "<", "3")->delete()){
            $this->error('Successfully Cleaned Database');
        }else{
            $this->info('Unable to Clean Database');
        }
        if(Ipsv6::whereis_permanent(0)->where('updated_at', '<', Carbon::now()->subHours(3)->toDateTimeString())->where('repetition', "<", "3")->delete()){
            $this->error('Successfully Cleaned IPv6 Database');
        }else{
            $this->info('Unable to Clean IPv6 Database');
        }
    }
}
