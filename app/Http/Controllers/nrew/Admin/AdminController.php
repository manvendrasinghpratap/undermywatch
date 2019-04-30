<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Links;
use App\Company;
use App\Domains;

class AdminController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
      $this->middleware('user');
    	$this->middleware('admin');
      //$this->middleware(['auth','user','admin']);
    }

    public function index(){

      $users = User::whereCompanyId(Auth::user()->company_id)->get();
      return view('admin.users.index')->with('users',$users);
    }
    public function admindashboard(Request $request){
    //  echo Auth::user()->company_id;
      $companyDomainsCount = $companyLinksCount = $companyLinkssum = $companySection = 0;
      $usersBelongsToCompany = $users = User::whereCompanyId(Auth::user()->company_id)->pluck('id','id');
      if(count($usersBelongsToCompany)>0){
            $companyDomainsCount = Domains::whereIn('addedby_id',$usersBelongsToCompany)->count();
            $companyLinksCount = Links::whereIn('createdby_id',$usersBelongsToCompany)->count();
            $companyLinkssum = Links::whereIn('createdby_id',$usersBelongsToCompany)->sum('clicks');
            $companySection = Company::whereId(Auth::user()->company_id)->first();
      }
    	return view('admin.admindashboard')->with('user', $this->user())
                ->with('companyLinksCount',$companyLinksCount)
                ->with('companyLinkssum',$companyLinkssum)
                ->with('companySection',$companySection)
                ->with('companyDomainsCount',$companyDomainsCount);
    }
    public function home(Request $request){
    	return view('admin.home')->with('user', $this->user());
    }

    public function user(){
        return Auth::user();
    }

    public function test(){
        var_dump(session('sumit'));
    }
    public function store(Request $request)
    {
      $request->validate([
          'email' => 'required|unique:users|max:255',
          'name' => 'required',
          'password' => 'required',
      ]);
      $userdata = New User;
      $userdata->name = $request->name;
      $userdata->email = $request->email;
      $userdata->email = $request->email;
      $userdata->notes = $request->notes;
      $userdata->level = config('app.userlevel');
      $userdata->company_id = Auth::user()->company_id;
      $userdata->password = Hash::make($request->password);
      $userdata->save();
      return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }
    public function create()
    {
      return view('admin.users.create');
    }

    public function destroy(Request $request,$id)
    {
       $id = base64_decode($id);
       User::where('id',  $id)->update(['level' => config('app.userlevel'),'deleted_at'=>date('Y-m-d G:i:s')]);
       if($request->ajax()){
           return response()->json(['status' => "User Deleted Successfully"]);
       }else{
         \Session::put(['status' => 'User Deleted Successfully']);
           return redirect()->back();
       }
    }

    public function assignedsection()
    {
        $assignedSection = Auth::user()->companyname->sections;
        return view('admin.sections.assignedsection')->with('assignedSection',$assignedSection);
      die();
    }
}
