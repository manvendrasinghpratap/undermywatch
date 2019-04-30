<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Sections;
use Illuminate\Support\Facades\Redirect;
use App\UserSection;
use App\CompanySection;


class CompanyController extends Controller
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
      $sections = Sections::orderby('created_at','desc')->get();
      return view('superadmin.company.index')->with('companyData',$companyData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('superadmin.company.addnewcompany');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $newCompany = new Company;
      $newCompany->company_name = $request->companyname;
      $newCompany->company_email = $request->company_email;
      $newCompany->contact_person = $request->contact_person;
      $newCompany->contact_no = $request->contact_no;
      $newCompany->company_address = $request->company_address;
      $newCompany->save();

      if($request->ajax()){
          return response()->json(['status' => "Link Updated Successfully", 'url' => "https://"]);
      }else{
        \Session::put(['status' => 'Company Added Successfully']);
        return Redirect()->back()->with(['message' => 'The Message']);
          //return redirect()->back();
      }
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
      $id = base64_decode($id);
      $companyDetails = Company::whereId($id)->first();
      $companyData = Company::get();
      $sections = Sections::orderby('created_at','desc')->get();
      return view('superadmin.company.edit')->with('companyDetails',$companyDetails)->with('sections',$sections);
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
        $id = base64_decode($id);
        $data['company_name']  = $request->companyname;
        $data['company_email']  = $request->company_email;
        $data['contact_person']  = $request->contact_person;
        $data['contact_no']  = $request->contact_no;
        $data['company_address']  = $request->company_address;
        //echo '<pre>'; print_r($data); echo '<pre>'; die();
        Company::where('id',  $id)
                ->update($data);
         return redirect()->back()->with('statu');
      //  return redirect()->route('superadmin.company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
       $data = Company::find($id)->delete();
       if($request->ajax()){
           return response()->json(['status' => "Company Deleted Successfully"]);
       }else{
         \Session::put(['status' => 'Company Deleted Successfully']);
           return redirect()->back()->with('status', "Company Profile Updated Successfully");
       }
    }

    public function changecompanystatus(Request $request)
    {
      $id = $request->company_id;
      $status = $request->valueSelected;
      $id = base64_decode($id);
      Company::where('id',  $id)
              ->update(['status' => $status]);
      return redirect()->back();
    }


    public function addNewUser()
    {
      $usertypeArray = array('3'=>'Team Member','4'=>'Admin');
      $companyData = Company::wherestatus(1)->get();
      $companyDataArray = $companyData->toArray();
      return view('superadmin.company.create')->with('companyDataArray',$companyDataArray)->with('usertypeArray',$usertypeArray);
    }

    public function saveNewUser(Request $request)
    {
      $request->validate([
          'email' => 'required|unique:users|max:255',
          'name' => 'required',
          'password' => 'required',
      ]);
      $userdata = New User;
      $userdata->name = $request->name;
      $userdata->email = $request->email;
      $userdata->level = $request->level;
      $userdata->company_id = $request->company_id;
      $userdata->notes = $request->notes;
      $userdata->password = Hash::make($request->password);
      $userdata->save();
      $companySection = Company::find($request->company_id);
      if(count($companySection->sections->toArray())>0){
        foreach($companySection->sections->toArray() as $data){
          $insertUserIdInUserSectionTbl             = new UserSection;
          $insertUserIdInUserSectionTbl->user_id    = $userdata->id;
          $insertUserIdInUserSectionTbl->section_id = $data['id'];
          $insertUserIdInUserSectionTbl->save();
        }
      }
      //return redirect('users')->with('success','User created Successfully.');
      return redirect()->route('superadmin.users.index')->with('success', 'User created successfully.');
    }

    public function editsingleuser(User $user, Request $request){
        $usertypeArray = array('3'=>'Team Member','4'=>'Admin');
        $companyData = Company::wherestatus(1)->get();
        $companyDataArray = $companyData->toArray();
        return view('superadmin.company.edituser')->with('companyDataArray',$companyDataArray)->with('usertypeArray',$usertypeArray)->with('user',$user);
    }

    public function updateUser(Request $request){
      $id = $request->user_id;
      if(!empty($id)) {
          $userdata = User::find($id);
          $userdata->name = $request->name;
          $userdata->email = $request->email;
          $userdata->level = $request->level;
          $userdata->company_id = $request->company_id;
          $userdata->notes = $request->notes;
          $userdata->save();
      }
      return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully.');
    }
}
