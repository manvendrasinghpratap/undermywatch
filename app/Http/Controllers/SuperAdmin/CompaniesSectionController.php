<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Companies_section;
use App\Sections;
use DB;
use App\CompanySection;
use App\Links;
use App\UserSection;

class CompaniesSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(){
        $this->middleware('auth');
        $this->middleware('superadmin');
     }

     public function index()
     {
       $companyData = Company::get();
       return view('superadmin.companysection.index')->with('companyData',$companyData);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create($id,Request $request){

      $id = base64_decode($request->id);
      $selectSectionArray = array();
      $selectedSection = DB::table('companies_sections')->where('company_id','=',$id)->get();

      foreach($selectedSection as $data){
         $selectSectionArray[] = $data->section_id;
      }
    //  echo '<pre>'; print_r($selectSectionArray); echo '</pre>';
      return view('superadmin.companysection.create')
                ->with('companyDetails',Company::find($id))
                ->with('selectSectionArray',$selectSectionArray)
                ->with('sections', Sections::get());

     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function campaign($companyId,Request $request)
    {
      $companyId = base64_decode($companyId);
      $userBelongsToCompany  = User::whereCompany_id($companyId)->pluck('id','id');
      //$this->pp($userBelongsToCompany,1);
      $querySectionString = '';
      $superadminlevel = config('app.superadminlevel');
      $adminlevel = config('app.adminlevel');
      $userlevel = config('app.userlevel');
      /*if(Auth::user()->level == $superadminlevel)
         $sections = Sections::get();
      */
     if($request->query('section_id')!= null ){
       $querySectionString = $request->query('section_id');
      // $links = Links::where('section_id',base64_decode($request->query('section_id')))->get();
       $links = Links::whereIn('createdby_id',$userBelongsToCompany)->where('section_id',base64_decode($request->query('section_id')))->get();
     }
     else {
       $links = Links::whereIn('createdby_id',$userBelongsToCompany)->get();
     }
      $sectionList =  UserSection::whereIn('user_id', $userBelongsToCompany)->pluck('section_id','section_id');
      $sections = Sections::whereIn('id', $sectionList)->orderby('created_at','desc')->get();
      //$this->pp($sections,1);
      $sections = $sections->toArray();
     return view('superadmin.campaigns.index')->with('links', $links)->with('sections',$sections)->with('querySectionString',$querySectionString);
    }

    public function deletecompanysection(Request $request)
    {
      $company_id       = base64_decode($request->company_id);
      $section_id    = base64_decode($request->section_id);
      if(!empty($request->section_id) && ($request->company_id))
      {
        CompanySection::where('company_id', $company_id)->where('section_id',$section_id)->delete();
        return redirect()->back()->with('status','Section delete Successfully from Company account');
      }
    //  return redirect()->back()->with('error','Section not delete from user account');
    }

    public function assigncompanysection(Request $request)
    {
      $company_id       = base64_decode($request->company_id); echo '<br>';
      $section_id       = base64_decode($request->section_id);
      if(!empty($request->section_id) && ($request->company_id))
      {
        $companySection = new CompanySection;
        $companySection->company_id = $company_id;
        $companySection->section_id = $section_id;
        $companySection->save();
        return redirect()->back()->with('status','Section Added Successfully in Company account');
      }
      return redirect()->back()->with('error','Section not Added in user account');
    }

    public function section($company_id,Request $request)
    {
      $company_id = base64_decode($company_id);
      $company = Company::find($company_id);
      $company->sections()->sync($request->get('sections', []) ?: []);
    	if($request->ajax()){
    		return response()->json(['status'=> "Successfully assigned section"]);
    	}else{
        //return redirect()->back()->with('status', "Successfully assigned section");
    		return redirect()->route('superadmin.company.section')->with('status', "Successfully assigned section");
    	}

    }

}
