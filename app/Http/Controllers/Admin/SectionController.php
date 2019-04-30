<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Sections;
use App\Links;
use App\LinkOptions;
use App\Domains;
use App\ScrapedPages;
use App\User;
use App\UserSection;
class SectionController extends Controller
{
    //
    private $dirs;

    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('admin');
        $_dirs = glob(base_path()."/landingpages/*" , GLOB_ONLYDIR);
        $this->dirs = [];
        foreach($_dirs as $_dir){
            $this->dirs[] = explode("/", $_dir)[count(explode("/", $_dir)) - 1];
        }
    }

    public function index(Request $request){
          $companyId =   Auth::user()->company_id;
          $userBelongsToCompany  = User::whereCompany_id($companyId)->pluck('id','id');
          $querySectionString = '';
          $superadminlevel = config('app.superadminlevel');
          $adminlevel = config('app.adminlevel');
          $userlevel = config('app.userlevel');
          /*if(Auth::user()->level == $superadminlevel)
          $sections = Sections::get();
          */
          if($request->query('section_id')!= null ){
          $querySectionString = $request->query('section_id');
          $links = Links::whereIn('createdby_id',$userBelongsToCompany)->where('section_id',base64_decode($request->query('section_id')))->get();
          }
          else {
          $links = Links::whereIn('createdby_id',$userBelongsToCompany)->get();
          }
          $sectionList =  UserSection::whereIn('user_id', $userBelongsToCompany)->pluck('section_id','section_id');
          $sections = Sections::whereIn('id', $sectionList)->orderby('created_at','desc')->get();
          $sections = $sections->toArray();
          return view('admin.sections.index')->with('user', $this->user())->with('links', $links)->with('sections',$sections)->with('querySectionString',$querySectionString);
    }

    public function section(Sections $section, Request $request){
      //  $this->pp($section,0);
        $userlevel = config('app.userlevel');
        if($this->user()->level== $userlevel)
        $domains = Domains::where('addedby_id',$this->user()->id)->orwhere('is_public',0)->latest()->get();
        elseif($this->user()->level== config('app.adminlevel')){
          $companyId =   Auth::user()->company_id;
          $userBelongsToCompany  = User::whereCompany_id($companyId)->pluck('id','id');
          $domains = Domains::whereIn('addedby_id',$userBelongsToCompany)->orwhere('is_public',0)->latest()->get();
        }elseif($this->user()->level== config('app.superadminlevel'))
        $domains = Domains::latest()->get();

    	$landingpages = $this->dirs;
    	$showalllinks = $request->get('all', 0) ?? 0;
    	if($showalllinks){
    		$links = $section->links;
    	}else{
    		$links = Links::wheresection_id($section->id)->wherecreatedby_id($this->user()->id)->get();
    	}
        return view('superadmin.campaigns.new')->with('section', $section)->with('links', $links)->with('domains', $domains)->with('landingpages', $landingpages);
    }

    public function createlink(Sections $section, Request $request){
      $countries = $request->get('countries');
      if(isset($countries)){
        $countriesimplode = implode(',',$countries);
      }
    //  $this->pp($request->all(),1);
        $domain = Domains::whereid($request->get('domain', null) ?? null)->first();
        $safe_link = $request->get('main_url', "") ?? "";
        $slug = $request->get('slug', "") ?? "";
        if(empty($slug)){
            $url_components = parse_url($safe_link);
            if(!empty($url_components['path'])){
                $l_p = explode("/", rtrim($url_components['path'], "/"));
                $slug = $l_p[count($l_p) - 1];
            }else{
                $slug = "";
            }
        }
        $name = $request->get('campaign_name', "") ?? "";
        $money_link = $request->get('money_url', "") ?? "";
        $landingpage = $request->get('landing_page', "") ?? "";
        $click_limit = $request->get('click_limit', 0) ?? 0;
        if(empty($domain)){
            if($request->ajax()){
                return response()->json(['error' => "Invalid Domain"]);
            }else{
                return redirect()->back()->with('error', "Domain Not Valid");
            }
        }
        if(!empty(Links::whereslug($slug)->wheredomain_id($domain->id)->first())){
            if($request->ajax()){
                return response()->json(['error' => "Domain Slug Combination Already Exists"]);
            }else{
                return redirect()->back()->with('error', "Domain Slug Combination Already Exists");
            }
        }
        if(empty($safe_link)){
            if($request->ajax()){
                return response()->json(['error' => "Main URL is must"]);
            }else{
                return redirect()->back()->with('error', "Main URL is must");
            }
        }
        $settings = $request->except(['domain','main_url','slug','campaign_name','money_url','landing_page','click_limit','_token']);
        if(isset($countries)){
          $settings['countries'] = $countriesimplode;
        }

        //$this->pp($settings,1);
        $link = new Links;
        $link->createdby_id = $this->user()->id;
        $link->updatedby_id = $this->user()->id;
        $link->section_id = $section->id;
        $link->domain_id = $domain->id;
        $link->name = $name;
        $link->slug = $slug;
        $link->safe_link = $safe_link;
        $link->money_link = $money_link;
        $link->landingpage = $landingpage;
        $link->click_limit = $click_limit;
        $link->notes = $request->get('extra_notes');
        if($link->save()){
            foreach($settings as $index => $value){
                $linkoption = new LinkOptions;
                $linkoption->link_id = $link->id;
                $linkoption->setting_name = $index;
                $linkoption->value = $value;
                $linkoption->save();
            }
        }else{
            if($request->ajax()){
                return response()->json(['error' => "Unable to save Link"]);
            }else{
                return redirect()->back()->with('error', "Unable to save Link");
            }
        }
        if($request->ajax()){
            return response()->json(['status' => "Link Saved Successfully", 'url' => "https://".$link->domain->domain."/".$link->slug]);
        }else{
            return redirect()->back()->with('status', "Link Saved Successfully")->with('url', "https://".$link->domain->domain."/".$link->slug);
        }
    }

    public function link(Links $link, Request $request){
      $userlevel = config('app.userlevel');
      if($this->user()->level== $userlevel)
      $domains = Domains::where('addedby_id',$this->user()->id)->orwhere('is_public',0)->latest()->get();
      elseif($this->user()->level== config('app.adminlevel')){
        $companyId =   Auth::user()->company_id;
        $userBelongsToCompany  = User::whereCompany_id($companyId)->pluck('id','id');
        $domains = Domains::whereIn('addedby_id',$userBelongsToCompany)->orwhere('is_public',0)->latest()->get();
      }elseif($this->user()->level== config('app.superadminlevel'))
      $domains = Domains::latest()->get();
    	$landingpages = $this->dirs;
    	return view('admin.sections.link')->with('link', $link)->with('domains', $domains)->with('landingpages', $landingpages);
    }

    public function linkupdate(Links $link, Request $request){
      $countries = $request->get('countries');
      if(isset($countries)){
        $countriesimplode = implode(',',$countries);
      }
        $domain = Domains::whereid($request->get('domain', null) ?? null)->first();
        $safe_link = $request->get('main_url', $link->safe_link) ?? $link->safe_link;
        $slug = $request->get('slug', $link->slug) ?? "";
        if(empty($slug)){
            $url_components = parse_url($safe_link);
            if(!empty($url_components['path'])){
                $l_p = explode("/", rtrim($url_components['path'], "/"));
                $slug = $l_p[count($l_p) - 1];
            }else{
                $slug = "";
            }
        }
        $name = $request->get('campaign_name', $link->name) ?? $link->name;
        $money_link = $request->get('money_url', $link->money_link) ?? $link->money_link;
        $landingpage = $request->get('landing_page', $link->landingpage) ?? $link->landingpage;
        $click_limit = $request->get('click_limit', 0) ?? 0;
        if(empty($domain)){
            if($request->ajax()){
                return response()->json(['error' => "Invalid Domain"]);
            }else{
                return redirect()->back()->with('error', "Domain Not Valid");
            }
        }
        if(!empty(Links::whereslug($slug)->wheredomain_id($domain->id)->where('id', '!=', $link->id)->first())){
            if($request->ajax()){
                return response()->json(['error' => "Domain Slug Combination Already Exists"]);
            }else{
                return redirect()->back()->with('error', "Domain Slug Combination Already Exists");
            }
        }
        if(empty($safe_link)){
            if($request->ajax()){
                return response()->json(['error' => "Main URL is must"]);
            }else{
                return redirect()->back()->with('error', "Main URL is must");
            }
        }
        $settings = $request->except(['domain','main_url','slug','campaign_name','money_url','landing_page','click_limit','_token']);
        if(isset($countries)){
          $settings['countries'] = $countriesimplode;
        }
        $link->updatedby_id = $this->user()->id;
        $link->domain_id = $domain->id;
        $link->name = $name;
        $link->slug = $slug;
        $link->safe_link = $safe_link;
        $link->money_link = $money_link;
        $link->landingpage = $landingpage;
        $link->click_limit = $click_limit;
        $link->notes = $request->get('extra_notes');
        if($link->save()){
            $link->settings()->delete();
            foreach($settings as $index => $value){
                $linkoption = new LinkOptions;
                $linkoption->link_id = $link->id;
                $linkoption->setting_name = $index;
                $linkoption->value = $value;
                $linkoption->save();
            }
        }else{
            if($request->ajax()){
                return response()->json(['error' => "Unable to update Link"]);
            }else{
                return redirect()->back()->with('error', "Unable to update Link");
            }
        }
        if($request->ajax()){
            return response()->json(['status' => "Link Updated Successfully", 'url' => "https://".$link->domain->domain."/".$link->slug]);
        }else{
            return redirect()->back()->with('status', "Link Updated Successfully")->with('url', "https://".$link->domain->domain."/".$link->slug);
        }
    }

    public function linkdelete(Links $link, Request $request){
        if($link->delete()){
            if($request->ajax()){
                return response()->json(['status' => "Successfully removed Link"]);
            }else{
                return redirect()->back()->with('status', "Successfully removed Link");
            }
        }else{
            if($request->ajax()){
                return response()->json(['error' => "Unable to remove"]);
            }else{
                return redirect()->back()->with('error', "Unable to remove");
            }
        }
    }

    public function linkscrape(Links $link, Request $request){
    	$response = $this->get_content($link->safe_link);
    	$sc_data = ScrapedPages::wherelink_id($link->id)->first();
    	if(empty($sc_data)){
    		$sc_data = new ScrapedPages;
    	}
    	$sc_data->link_id = $link->id;
    	$sc_data->content = json_encode($response);
    	if($sc_data->save()){
            if($request->ajax()){
                return response()->json(['status' => "Successfully Scraped Link"]);
            }else{
                return redirect()->back()->with('status', "Successfully Scraped Link");
            }
        }else{
            if($request->ajax()){
                return response()->json(['error' => "Unable to Scrape"]);
            }else{
                return redirect()->back()->with('error', "Unable to Scrape");
            }
        }
    }

    public function get_content($url) {
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_FAILONERROR, true);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 15);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	    $response = curl_exec($curl);
	    $type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
	    curl_close($curl);
	    return ['response' => $response, "type" => $type];
	}

    public function user(){
    	return Auth::user();
    }

}
