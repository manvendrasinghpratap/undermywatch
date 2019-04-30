<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateGeoIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geoip:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update GeoIP data';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $updatedate;
    protected $license_key;
    protected $geoip2_ispsource;
    protected $geoip2_countrysource;

    public function __construct()
    {
        parent::__construct();
        $this->updatedate = date("Ymd", strtotime("last tuesday"));
        $this->freeupdatedate = date("Ymd", strtotime("last tuesday"));
        $this->license_key = config('geoip.license_key', "");
        $this->geoip2_ispsource  = "https://download.maxmind.com/app/geoip_download?edition_id=GeoIP2-ISP&date=".$this->updatedate."&license_key=".$this->license_key."&suffix=tar.gz";
        $this->geoip2_countrysource  = "https://download.maxmind.com/app/geoip_download?edition_id=GeoIP2-Country&date=".$this->updatedate."&license_key=".$this->license_key."&suffix=tar.gz";
        $this->geoip2_citysource  = "https://geolite.maxmind.com/download/geoip/database/GeoLite2-City.tar.gz";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->geoip_update_city_db_now('country');
        $this->geoip_update_city_db_now('isp');
        $this->geoip_update_city_db_now('city');
    }

    public function isp_update_source(){
        $download_url = $this->geoip2_ispsource;
        return $download_url;
    }

    public function country_update_source(){
        $download_url = $this->geoip2_countrysource;
        return $download_url;
    }

    public function city_update_source(){
        $download_url = $this->geoip2_citysource;
        return $download_url;
    }

    public function isp_maxmindGetUploadFilename()
    {
        $filename = base_path().'/firewall/geoipdb/GeoIP2-ISP.mmdb';
        return $filename;
    }

    public function country_maxmindGetUploadFilename()
    {
        $filename = base_path().'/firewall/geoipdb/GeoIP2-Country.mmdb';
        return $filename;
    }

    public function city_maxmindGetUploadFilename()
    {
        $filename = base_path().'/firewall/geoipdb/GeoLite2-City.mmdb';
        return $filename;
    }

    public function geoip_download_url($url, $db = "isp", $modified = 0)
    {
        $tmp = base_path()."/firewall/geoipdb/".$db."-".date("Y-m-d-H-m-i-")."tmpdb.tar.gz";
        $content = @file_get_contents($url);
        if(!$content){
            $this->error('Unable to Download File');
            return false;
        }else{
            file_put_contents($tmp, $content);
            $this->info("Downloaded: ".$this->filesize_formatted($tmp));
        }
        return $tmp;
    }

    public function geoip_update_city_db_now($db="isp")
    {
        if(strtolower($db) == 'isp'){
            $download_url = $this->isp_update_source();
            $outFile = $this->isp_maxmindGetUploadFilename();
        }elseif(strtolower($db) == 'country'){
            $download_url = $this->country_update_source();
            $outFile = $this->country_maxmindGetUploadFilename();
        }elseif(strtolower($db) == 'city'){
            $download_url = $this->city_update_source();
            $outFile = $this->city_maxmindGetUploadFilename();
        }else{
            $this->error("Invalid DB Selected");
            return;
        }
        if(file_exists($outFile)){
            $modified = @filemtime($outFile);
        }else{
            $modified = 0;
        }
        $tmpFile = $this->geoip_download_url($download_url, $db, 0);
        if (!file_exists($tmpFile)){
            $this->error('Downloaded file could not be opened for reading.');
            return;
        }
        $dir = @scandir('phar://' . $tmpFile)[0];
        // $this->error("$dir");
        if (!$dir){
            unlink($tmpFile);
            $this->error('Downloaded file could not be opened for reading.');
            return;
        }
        if(strtolower($db) == 'country'){
            $in = fopen('phar://' . $tmpFile . '/GeoIP2-Country_' . $this->updatedate . '/GeoIP2-Country.mmdb', 'r');
        }elseif(strtolower($db) == 'isp'){
            $in = fopen('phar://' . $tmpFile . '/GeoIP2-ISP_' . $this->updatedate . '/GeoIP2-ISP.mmdb', 'r');
        }elseif(strtolower($db) == 'city'){
            $in = fopen('phar://' . $tmpFile . '/GeoLite2-City_' . $this->updatedate . '/GeoLite2-City.mmdb', 'r');
        }else{
            $this->error("Invalid DB Selected");
            return;
        }
        $out = fopen($outFile, 'w');
        if (!$in){
            unlink($tmpFile);
            $this->error('Downloaded file could not be opened for reading.');
            return;
        }
        if (!$out){
            unlink($tmpFile);
            $this->info("Database could not be written");
            return; 
        }
        while (($string = fread($in, 4096)) != false ){
            fwrite($out, $string, strlen($string));
        }
        fclose($in);
        fclose($out);
        unlink($tmpFile);
        $this->info("$db Database updated");
        return true;
    }

    public function filesize_formatted($path)
    {
        $size = filesize($path);
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
