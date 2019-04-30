<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GeoIp2\Database\Reader;
use App\Ips;
use App\Isps;
use App\Links;
use App\Domains;
use App\ScrapedPages;
use Session;
use Carbon\Carbon;
use Redirect;
use Cookie;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Ipsv6;
use App\UniqueGclids;
use App\Referer;

class SnapAppApiController extends Controller
{
    //

    public $request;
    protected $link;
    protected $ispreader;
    protected $countryreader;
    protected $cityreader;
    protected $botuseragentsdata;
    protected $ip;
    protected $isp;
    protected $organization;
    protected $country;
    protected $blocked;
    protected $reason;
    protected $is_link;
    protected $is_ipv6;

    public function init(){
        $this->reason = array();
        $this->is_ipv6 = false;
        $this->blocked = 0;
        $this->getuserip();
        $this->getLink();
    }

    public function reviewip(Request $request){
        $this->request = $request;
        $this->is_ipv6 = false;
        $this->getuserip();
        $link = $this->getLinkfromId();
        if(!empty($link) && !$this->is_ipv6){
            $this->addIPagainstCamp($this->ip, $link);
        }
    }

    public function addIPagainstCamp($ip, $link){
        $longip = bindec(decbin(ip2long($ip)));
        $ip = Ips::where('start', '>=', $longip)->where('end', '<=', $longip)->first();
        if(empty($ip)){
            $ip = new Ips;
            $ip->start = $longip;
            $ip->end = $longip;
            $ip->repetition = 0;
        }
        $ip->save();
        $piv = $ip->campaigns()->withPivot("clicks")->find($link->id);
        if(empty($piv)){
            $ip->campaigns()->attach($link->id);
            $piv = $ip->campaigns()->withPivot("clicks")->find($link->id);
        }
        $ip->campaigns()->updateExistingPivot($link->id, ["clicks" => ($piv->pivot->clicks+1)]);
        return;
    }

    public function getLinkfromId(){
        $link_id = $this->request->get("link", "0");
        $link = Links::whereid($link_id)->first();
        return $link;
    }

    public function render(Request $request){
        $this->request = $request;
        $this->init();
        if(!empty($this->link)){
            if($this->isClickBlocked() || $this->isRefererBlocked() || $this->isNotMobile() || $this->isBlockedByFirewall() || $this->isCountriesBlocked() || $this->isBlockedNonexistentReferral() || $this->isBlockedReferral() || $this->isnonexistentGclid() || $this->isuniqueexistentGclid()){
                if($this->isActiveField('loglink') && $this->getValue('loglink')){
                    $this->loglink(true);
                }
                return $this->blockedResponse();
                
            }else{
                if($this->isActiveField('loglink') && $this->getValue('loglink')){
                    $this->loglink(true);
                }
                return $this->unblockedResponse();
            }
        }else{
            return $this->abort();
        }
    }

    public function blockedResponse(){
        return response()->json(['status' => "blocked", "url" => $this->link->safe_link]);
    }

    public function unblockedResponse(){
        if($this->isTimezoneCheckEnabled()){
            return response()->json([
                "status" => "passed", 
                "url"=> $this->link->money_link, 
                "id" => $this->link->id, 
                "surl"=> $this->link->safe_link,  
                "timezoneoffset" => $this->getTimeZoneOffset()
            ]);
        }else{
            return response()->json([
                "status" => "passed", 
                "url"=> $this->link->money_link, 
                "id" => $this->link->id, 
                "surl"=> $this->link->safe_link
            ]);
        }
    }

    public function getLink(){
        $_slug = ltrim($this->requestpath(),"/");
        $domain = Domains::wheredomain($this->getDomain())->first();
        if(empty($domain) || empty(Links::wheredomain_id($domain->id)->first())){
            return $this->abort();
        }

        $this->logdomain($domain);
        $link = Links::wheredomain_id($domain->id)->whereslug(rtrim($_slug, "/"))->first();
        if(!empty($link)){
            $this->is_link = true;
            $link = Links::wheredomain_id($domain->id)->whereslug(rtrim($_slug, "/"))->first(); // Recall Link to avoid click limit errors
            $this->link = $link;
            $this->setClick();
        }
        if(empty($this->link)){
            return $this->abort();
        }
    }

    public function isClickBlocked(){
        if($this->isActiveField('click_limit')){
            if($this->link->clicks < $this->getinlineValue('click_limit', $this->link->click_limit)){
                $this->blocked(1);
                $this->reason('clicklimit');
                return true;
            }
        }
        return false;
    }

    public function isNotMobile(){
        if($this->isActiveField('mobile_only')){
            if($this->getValue('mobile_only')){
                if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$this->requestUserAgent())||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($this->requestUserAgent(),0,4))){
                }else{
                    $this->blocked(1);
                    $this->reason('mobileonly');
                    return true;
                }
            }
        }
        return false;
    }

    public function isBlockedByFirewall(){
        if($this->isActiveField('enable_firewall') && $this->getValue('enable_firewall')){
            $this->fetchgeoipdata();
            if($this->isBlockedISP() || $this->isBlockedIP() || $this->isBlockedIPv6() || $this->isBlockedUserAgent() || $this->isBlockedHost()){
                $this->blocked(1);
                $this->reason('BlockedbyFirewall');
                return true;
            }
        }
        return false;
    }

    public function isRefererBlocked(){
        if($this->isActiveField('referer_firewall') && $this->getValue('referer_firewall')){
            $referer = "";
            if(!empty($this->requestReferer())){
                $referer = $this->requestReferer();
            }
            if(empty($referer)){
                $this->blocked(1);
                $this->reason('Empty Referer');
                return true;
            }
            $parsed = parse_url($referer);
            if(empty($parsed['host'])){
                $this->blocked(1);
                $this->reason('Invalid Referer');
                return true;
            }
            $host = strtolower(preg_replace('/^www./', '', $parsed['host']));
            $ref = Referer::wherereferer($host)->first();
            if(empty($ref)){
                $ref = new Referer;
                $ref->referer = $host;
                $ref->save();
            }
            if(!empty(Referer::wherereferer($host)->whereisreviewed(1)->whereisblocked(1)->first()) || !empty(Referer::wherereferer($host)->whereisreviewed(0)->whereisblocked(0)->first())){
                $this->blocked(1);
                $this->reason('Referer Firewall');
                return true;
            }
        }
        return false;
    }

    public function isBlockedHost(){
        if(strpos(strtolower(gethostbyaddr($this->requestip())),"google") !== false ){
            $this->blocked(1);
            $this->reason('hostBlocked');
            return true;
        }
        return false;
    }

    public function isCountriesBlocked(){
        $this->fetchgeoipdata();
        if($this->isActiveField('countries_list')){
            $countries_list = $this->getValue('countries_list');
            if($this->isActiveField('is_countries_blocked')){
                $is_blocked = $this->getValue('is_countries_blocked');
            }else{
                $is_blocked = 0;
            }
            if(!empty($countries_list)){
                $countries = explode(",", trim(rtrim(strtolower($countries_list),",")));
                if(!(in_array(strtolower($this->country), $countries) xor $is_blocked)){
                    $this->blocked(1);
                    $this->reason('blockedcountry');
                    return true;
                }
            }
        } 
        return false;
    }

    public function isBlockedNonexistentReferral(){
        if($this->isActiveField('referral_exists')){
            if($this->getValue('referral_exists')){
                if(empty($this->requestReferer())){
                    $this->blocked(1);
                    $this->reason('referral_exists');
                    return true;
                }
            }
        }
        return false;
    }

    public function getTimeZoneOffset(){
        $this->cityreader = new Reader(base_path()."/firewall/geoipdb/GeoLite2-City.mmdb");
        try{
            $citydata = $this->cityreader->city($this->requestip());
            $timezone = $citydata->location->timeZone;
            $offset = Carbon::now($timezone)->offsetHours;
            $ipoffset = $offset*-60;
        }
        catch(\Exception $e){
            $ipoffset = -1000;
        }
        return $ipoffset;
    }

    public function isBlockedIPv6(){
        if($this->isActiveField('blockipv6') && $this->getValue('blockipv6')){
            if($this->is_ipv6){
                $this->blocked(1);
                $this->reason("IPv6");
                return true;
            }
        }
        return false;
    }

    public function isBlockedReferral(){
        if($this->isActiveField('filter_referral')){
            $ref = $this->requestReferer();
            $valid_referrals = $this->getValue('filter_referral');
            if(empty($ref)){
                $this->blocked(1);
                $this->reason('emptyreferral');
                return true;
            }
            foreach(explode(",", $valid_referrals) as $valid_referral){
                if (strpos(strtolower($ref), strtolower($valid_referral)) !== false) {
                    return false;
                }
            }
            $this->blocked(1);
            $this->reason('referralfilter');
            return true;   
        }
    }

    public function isnonexistentGclid(){
        if($this->isActiveField('gclid_exists')){
            if($this->getValue('gclid_exists')){
                if(!$this->requestHasGclid()){
                    $this->blocked(1);
                    $this->reason('gclid');
                    return true;
                }
            }
        }
        return false;
    }

    public function isBlockedIP(){
        if($this->is_ipv6){
            $cutshortipv6 = $this->get_trimmed_ipv6($this->requestip());
            $this->recordipv6($cutshortipv6);
            if(!empty(Ipsv6::where('updated_at', '>', Carbon::now()->subHours(2)->toDateTimeString())->where('ip', $cutshortipv6)->first()) && Ipsv6::where('updated_at', '>', Carbon::now()->subHours(2)->toDateTimeString())->where('ip', $cutshortipv6)->first()->repetition > 1){
                $this->blocked(1);
                $this->reason('ipv6block');
                return true;
            }
        }else{
            $longip = bindec(decbin(ip2long($this->requestip())));
            $this->recordip($longip);
            {
                $csize = 42949673;
                $ip_fno = ceil($longip/$csize);
                if($ip_fno == 0){
                    $ip_fno = 1;
                }
                $ipfilerange = base_path()."/firewall/ips/data/ip$ip_fno.csv";
                $fileName = $ipfilerange;
                $file = fopen($fileName,'r');
                while(!feof($file)) {
                    $line = fgets($file);
                    $line_data = str_getcsv($line);
                    if(isset($line_data[0]) && isset($line_data[1]) && $line_data[0] <= $longip && $line_data[1] >= $longip){
                        $this->blocked(1);
                        if(is_string($line_data[2])){                   
                            $this->reason($line_data[2]);
                            try{
                                $reason = json_decode($line_data[2]);

                            }catch(Exception $e){

                            }
                        }else{
                            $this->reason('{"Unknown Line"}');
                        }
                        return true;
                    }
                    
                }
            }
            if(!empty(Ips::whereis_permanent(1)->where('start', '>=', $longip)->where('end', '<=', $longip)->first())){
                $this->blocked(1);
                $this->reason('permanentipblock');
                return true;
            }
            if(!empty(Ips::whereis_permanent(0)->where('updated_at', '>', Carbon::now()->subHours(2)->toDateTimeString())->where('start', '>=', $longip)->where('end', '<=', $longip)->first()) && Ips::whereis_permanent(0)->where('updated_at', '>', Carbon::now()->subHours(2)->toDateTimeString())->where('start', '>=', $longip)->where('end', '<=', $longip)->first()->repetition > 1){
                $this->blocked(1);
                $this->reason('temporaryipblock');
                return true;
            }
        }
        return false;
    }

    public function isBlockedISP(){
        if($this->isActiveField('bypass_whitelisted_isp') && $this->getValue('bypass_whitelisted_isp')){
            if(!empty(Isps::whereisp($this->isp)->whereisblocked(0)->whereisreviewed(1)->first())){
                return false;
            }
        }
        if(!empty(Isps::whereisp($this->isp)->first())){
            $this->blocked(1);
            $this->reason('blacklistedisp');
            return true;
        }
        return false;
    }

    public function isBlockedASN(){
        if(strpos(strtolower($this->ASO), 'google') !== false){
            return false;
        }
        $this->blocked(1);
        $this->reason('Blocked ASO');
        return true;
    }

    public function isBlockedUserAgent(){
        $this->loadbotuseragentsdata();
        if(empty($this->requestUserAgent())){
            return false;
        }

        $patterns = array();
        foreach($this->botuseragentsdata as $entry) {
            $patterns[] = $entry['pattern'];
        }
        $useragent = $this->requestUserAgent();
        foreach($patterns as $pattern){
            if(strpos($useragent, $pattern) !== false){
                $this->blocked(1);
                $this->reason('blockeduseragent');
                return true;
            }
        }
        return false;
    }

    public function setClick(){
        $this->link->clicks++;
        $this->link->save();
    }

    public function isActiveField($key){
        if(!empty($this->link->section->settings->where('field', $key)->first())){
            return true;
        }
        return false;
    }

    public function getinlineValue($key, $default){
        if($this->link->section->settings->where('field', $key)->first()->is_hidden){
            return $this->link->section->settings->where('field', $key)->first()->default;
        }
        return $default ?? $this->link->section->settings->where('field', $key)->first()->default;
    }

    public function getValue($key){
        if($this->link->section->settings->where('field', $key)->first()->is_hidden){
            return $this->link->section->settings->where('field', $key)->first()->default;
        }
        return $this->link->settings->where('setting_name', $key)->first()->value ?? $this->link->section->settings->where('field', $key)->first()->default;
    }

    public function reason($reason){
        $this->reason[] = $reason;
    }

    public function fetchgeoipdata(){
        $this->ispreader = new Reader(base_path()."/firewall/geoipdb/GeoIP2-ISP.mmdb");
        $this->countryreader = new Reader(base_path()."/firewall/geoipdb/GeoIP2-Country.mmdb");
        try{
            $ispdata = $this->ispreader->isp($this->requestip());
            $this->isp = $ispdata->isp;
            $this->organization = $ispdata->organization;
        }
        catch(\Exception $e){
            if(empty($this->isp)){
                $this->isp = "Unknown";
            }
            $this->organization = "-";
        }
        try{
            $countrydata = $this->countryreader->country($this->requestip());
            $this->country = strtolower($countrydata->country->isoCode);
        }
        catch(\Exception $e){
            $this->country = "zz";
        }
    }

    public function getuserip(){
        $this->ip = $this->requestip();
    }

    public function recordip($longip){
        $ip = Ips::where('start', '>=', $longip)->where('end', '<=', $longip)->first();
        if(empty($ip)){
            $ip = new Ips;
            $ip->start = $longip;
            $ip->end = $longip;
            $ip->repetition = 0;
        }
        if(!empty($this->organization)){
            $ip->organization = $this->organization;
        }
        if(!empty($this->isp)){
            $ip->isp = $this->isp;
        }
        $ip->repetition++;
        $ip->save();
    }

    public function recordipv6($cip){
        $ip = Ipsv6::where('ip', $cip)->first();
        if(empty($ip)){
            $ip = new Ipsv6;
            $ip->ip = $cip;
            $ip->repetition = 0;
        }
        if(!empty($this->organization)){
            $ip->organization = $this->organization;
        }
        if(!empty($this->isp)){
            $ip->isp = $this->isp;
        }
        $ip->repetition++;
        $ip->save();
    }

    public function loadbotuseragentsdata(){
        $this->botuseragentsdata = json_decode(file_get_contents(base_path().'/firewall/crawler/crawler-user-agents.json'), true);
    }

    private function removeFromBeg($haystack, $needle){
        $length = strlen($needle);
        if($needle.substr($haystack, $length) === $haystack)
        {
            $haystack = substr($haystack, $length);
        }
        return $haystack;
    }

    public function requestgetMethod(){
        return "API";
    }

    public function isTimezoneCheckEnabled(){
        if(!empty($this->request->get('timezonecheck', 0))){
            return true;
        }
        return false;
    }

    public function getDomain(){
        $domain = $this->removeFromBeg($this->request->get("domain", "localhost"), "www.");
        return $domain;
    }

    public function requestpath(){
        $path = ltrim($this->request->get("path", "/"), "/");
        return $path;
    }

    public function getRequestParams(){
        $params = $this->request->get("params", []);
        return $params;
    }

    public function getRequestHeaders(){
        $headers = $this->request->get("headers", []);
        return $headers;
    }

    public function requestHasGclid(){
        if(isset($this->getRequestParams()['gclid'])){
            return true;
        }
        return false;
    }

    public function requestGclid(){
        if(isset($this->getRequestParams()['gclid'])){
            return $this->getRequestParams()['gclid'];
        }
        return false;
    }

    public function requestUserAgent(){
        $useragent = $this->request->get('useragent', "");
        return $useragent;
    }

    public function isuniqueexistentGclid(){
        // return false;
        $uniqueGclids = new UniqueGclids();
        $uniqueGclids->gclid = $this->requestGclid();

        if($this->requestHasGclid()){
            $is_unique_or_not =  UniqueGclids::where('gclid',$this->requestGclid())->count();
            if(!$is_unique_or_not){
                $uniqueGclids->save();
            }
        }

        if($this->isActiveField('unique_gclid_exists')){
            if($this->getValue('unique_gclid_exists')){
                
                if(strlen($this->requestGclid()) < 30 || strpos($this->requestGclid(), "_") === false){
                    $this->blocked(1);
                    $this->reason('Gcl Id is already Exist _');
                    return true;
                }
                if(!$this->requestHasGclid() || empty($this->requestGclid())){
                    $this->blocked(1);
                    $this->reason('Gcl Id is not exist in Url');
                    return true;
                }elseif($is_unique_or_not){
                    $this->blocked(1);
                    $this->reason('Gcl Id is already Exist');
                    return true;
                }else{
                    return false;
                }
            }
        }
        return false;
    }

    public function requestReferer(){
        $referer = $this->request->get('referer', "");
        return $referer;
    }

    public function logdomain($domain){ 
        $log = [
            "IP" => $this->requestip(), 
            "method" => $this->requestgetMethod(), 
            "path" => $this->requestpath(), 
            "query" => $this->getRequestParams(), 
            "referer" => $this->requestReferer(),
            "UserAgent" => $this->requestUserAgent()
        ];
        $ReportsLog = new Logger($domain->domain);
        $ReportsLog->pushHandler(new StreamHandler(storage_path('logs/domains/'.$domain->domain.date('-Y-m-d').'.log')), Logger::INFO);
        $ReportsLog->info($domain->domain, $log);
        return;
    }

    public function loglink($main = false){
        if(empty($this->link)){
            return;
        }
        if($this->isActiveField("loglink") && $this->getValue("loglink")){
            if($main){
                $log = [
                    "Type" => "Main", 
                    "Status" => $this->blocked ? "Blocked" : "Passed", 
                    "Reason" => $this->reason, 
                    "IP" => $this->requestip(), 
                    "method" => $this->requestgetMethod(), 
                    "path" => $this->requestpath(), 
                    "query" => $this->getRequestParams(), 
                    "referer" => $this->requestReferer(),
                    "UserAgent" => $this->requestUserAgent(),
                    "headers" => $this->getRequestHeaders()
                ];
            }
            $ReportsLog = new Logger($this->link->id);
            $ReportsLog->pushHandler(new StreamHandler(storage_path('logs/links/link'.$this->link->id.date('-Y-m-d').'.log')), Logger::INFO);
            $ReportsLog->info($this->link->id, $log);
        }
        return;
    }

    public function blocked($status = 0){
        $this->blocked = $status;
    }
    
    public function requestip(){
        $ip = $this->request->get("ip", "");
        $this->validate_ip($ip);
        return $ip;
    }
    
    
    public function validate_ip($ip){
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        }else{
            $this->is_ipv6 = true;
        }
        return true;
    }

    public function get_temp_ipv4($ip){
        $newip = explode(":", $ip)[0].explode(":", $ip)[1];
       return hexdec($newip);
    }
    public function get_trimmed_ipv6($ip){
        $newip = explode(":", $ip)[0].":".explode(":", $ip)[1].":".explode(":", $ip)[2].":".explode(":", $ip)[3].":".explode(":", $ip)[4];
        return $newip;
    }

    public function abort($httpcode = 404){
        if($httpcode === 404){
            return response()->json(['error' => true, "reason" => "Not Found"]);
        }else{
            return response()->json(['error' => true, "reason" => "Unknown"]);
        }
    }

}
