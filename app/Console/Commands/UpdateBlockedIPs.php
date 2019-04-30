<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class UpdateBlockedIPs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockedip:update {csvsource?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Blocked IPs';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $csvsource;

    public function __construct()
    {
        parent::__construct();
        $this->csvsource  = "http://firewall.adupmedia.com/ip_filter_v2/ip_export.csv";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->csvsource = $this->argument('csvsource') ?? $this->csvsource;
        $csize = 42949673;
        $file = base_path()."/firewall/ips/ip_export.csv";
        $fileName = $file;
        $content = @file_get_contents($this->csvsource);
        if(!$content){
            $this->error('Unable to Download Update');
        }else{
            file_put_contents($file, $content);
            $this->info("Downloaded: ".$this->filesize_formatted($file));
            if(file_exists($file)){
                $file = fopen($fileName,'r');
                for($i=1;$i<=100;$i++){
                    ${"fpnewpath$i"} = base_path()."/firewall/ips/data/ip$i.csv.new";
                    ${"fpoldpath$i"} = base_path()."/firewall/ips/data/ip$i.csv";
                    ${"fpbackpath$i"} = base_path()."/firewall/ips/data/ip$i.csv.old";
                    ${"fp$i"} = fopen(${"fpnewpath$i"},"w");
                }
                $starttime = date('m:i:s');
                while(!feof($file)) {
                    $line = fgets($file);
                    $ar = str_getcsv($line);
                    for($i=1;$i<=100;$i++){
                        if(isset($ar[0]) && isset($ar[1]) && (($ar[0] >= $csize*($i-1) && $ar[0] <= $csize*$i) || ($csize >= $ar[0] && $csize <= $ar[1]))){ 
                            fputcsv(${"fp$i"}, $ar);
                        }
                    }
                }
                fclose($file);
                for($i=1;$i<=100;$i++){
                    fclose(${"fp$i"});
                    if(file_exists(${"fpnewpath$i"}) && filesize(${"fpnewpath$i"})){
                        if(file_exists(${"fpoldpath$i"})){
                            rename(${"fpoldpath$i"}, ${"fpbackpath$i"});
                        }
                        rename(${"fpnewpath$i"}, ${"fpoldpath$i"});
                        if(file_exists(${"fpbackpath$i"})){
                            unlink(${"fpbackpath$i"});
                        }
                    }
                }
                $this->info('Successfully Updated Database');
            }else{
                $this->error('Main file not found');
            }
        }
    }

    public function filesize_formatted($path)
    {
        $size = filesize($path);
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
