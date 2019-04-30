<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Sections;
use App\Company;
use App\UserSection;
use App\Links;
use App\LinkOptions;

class UsersettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(){
          $this->middleware('auth');
          $this->middleware('admin');
          $this->middleware('superadmin');
     }

     public function index($user,Request $request){
       $enableOrDisableUser = 'Disable User';
       $userStatus = 'Active';
       $userType = 'Normal User';
       $userchangeType = 'Admin';
       $currentLevel = 'user';
       $switchToUserType = 'Switch to Admin';
       $texttochange = 'Switch to User';
       $companies = Company::pluck('company_name','id');
       $userDetails = User::findOrFail(base64_decode($user));
       if($userDetails->status==0){
         $enableOrDisableUser = 'Enable User';
         $userStatus = 'In-active';
       }
       if($userDetails->level == config('app.adminlevel')){
          $switchToUserType = 'Switch to User';
          $userType = 'Admin';
          $currentLevel = 'admin';
          $userchangeType = 'Normal User';
          $texttochange = 'Switch to Admin';
       }
       $userDetails->company_id;
       $companySection = Company::find($userDetails->company_id);
     	return view('superadmin.usersetting.index')
                ->with('userType',$userType)
                ->with('switchToUserType',$switchToUserType)
                ->with('texttochange',$texttochange)
                ->with('currentLevel',$currentLevel)
                ->with('enableOrDisableUser',$enableOrDisableUser)
                ->with('userStatus',$userStatus)
                ->with('userchangeType',$userchangeType)
                ->with('companies',$companies)
                ->with('companySection',$companySection)
                ->with('userDetails',$userDetails);
     }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function updateprofile($userId, Request $request)
    {
      //$this->pp($request->all(),0);
      if($request->get('userid')==base64_decode($userId)){
        if($request->ajax()){
          return response()->json(['status'=>'User Profile Updated Successfully']);
        }
        else {
          $userdata                 = User::find($request->get('userid'));
          $userdata->name           = $request->get('name_');
          $userdata->email          = $request->get('email');
          $userdata->skypeid        = $request->get('skypeid');
          $userdata->company_id     = $request->get('company_id');
          $userdata->notes          = $request->get('notes');

          $userdata->save();

          return redirect()->back()->with('status','User Profile Updated Successfully');
        }
      }
    }
    public function campaign($user_id,Request $request)
    {
      $userId = base64_decode($user_id);
      $querySectionString = '';
      $superadminlevel = config('app.superadminlevel');
      $adminlevel = config('app.adminlevel');
      $userlevel = config('app.userlevel');
      /*if(Auth::user()->level == $superadminlevel)
         $sections = Sections::get();
      */
     if($request->query('section_id')!= null ){
       $querySectionString = $request->query('section_id');
       $links = Links::wherecreatedby_id($userId)->where('section_id',base64_decode($request->query('section_id')))->get();
     }
     else {
       $links = Links::wherecreatedby_id($userId)->get();
     }
      $sectionList =  UserSection::where('user_id', $userId)->pluck('section_id','section_id');
      $sections = Sections::whereIn('id', $sectionList)->orderby('created_at','desc')->get();
      //$this->pp($sections,1);
      $sections = $sections->toArray();
     return view('superadmin.campaigns.index')->with('links', $links)->with('sections',$sections)->with('querySectionString',$querySectionString);
    }
    public function deleteUserSection(Request $request)
    {
      $user_id       = base64_decode($request->user_id);
      $section_id    = base64_decode($request->section_id);
      if(!empty($request->section_id) && ($request->user_id))
      {
        UserSection::where('user_id', $user_id)->where('section_id',$section_id)->delete();
        return redirect()->back()->with('status','Section delete Successfully from Users account');
      }
      return redirect()->back()->with('error','Section not delete from user account');
    }

    public function assignUserSection(Request $request)
    {
      $user_id       = base64_decode($request->user_id); echo '<br>';
      $section_id    = base64_decode($request->section_id);
      if(!empty($request->section_id) && ($request->user_id))
      {
        $UserSection = new UserSection;
        $UserSection->user_id = $user_id;
        $UserSection->section_id = $section_id;
        $UserSection->save();
        return redirect()->back()->with('status','Section Inserted Successfully in Users account');
      }
      return redirect()->back()->with('error','Section not Inserted in user account');
    }


}
