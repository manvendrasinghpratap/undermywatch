<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Links;
use App\Sections;
use Auth;
use App\LinkOptions;
use App\Domains;
use App\ScrapedPages;
class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
       $querySectionString = '';
       $superadminlevel = config('app.superadminlevel');
       $adminlevel = config('app.adminlevel');
       $userlevel = config('app.userlevel');
       /*if(Auth::user()->level == $superadminlevel)
          $sections = Sections::get();
       */
      if($request->query('section_id')!= null ){
        $querySectionString = $request->query('section_id');
        $links = Links::where('section_id',base64_decode($request->query('section_id')))->get();
      }
      else {
        $links = Links::get();
      }
      $sections = Sections::orderby('created_at','desc')->get();
      //$sections = Sections::pluck('name','id');
      $sections = $sections->toArray();
     	return view('superadmin.campaigns.index')->with('links', $links)->with('sections',$sections)->with('querySectionString',$querySectionString);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      if(Auth::user()->level==config('app.superadminlevel'))
            $domains = Domains::latest()->get();
        else
            $domains = Domains::where('addedby_id',Auth::user()->id)->orwhere('is_public',0)->latest()->get();

    	$landingpages = $this->dirs;
    	$showalllinks = $request->get('all', 0) ?? 0;
    	if($showalllinks){
    		$links = $section->links;
    	}else{
    		$links = Links::wheresection_id($section->id)->wherecreatedby_id($this->user()->id)->get();
    	}
        return view('admin.sections.section')->with('section', $section)->with('links', $links)->with('domains', $domains)->with('landingpages', $landingpages);
        return view('superadmin.campaigns.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->pp($request->all(),'1');
        $links  = new Links;
        $links->name = $request->get('campaignname');
        $links->name = $request->get('campaignname');
        $links->name = $request->get('campaignname');
        $links->name = $request->get('campaignname');
        $links->name = $request->get('campaignname');
        $links->name = $request->get('campaignname');
        $links->name = $request->get('campaignname');
        $links->name = $request->get('campaignname');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
