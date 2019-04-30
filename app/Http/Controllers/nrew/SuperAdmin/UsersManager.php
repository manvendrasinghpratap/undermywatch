<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Sections;
use App\Company;

class UsersManager extends Controller
{
    ///
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('admin');
    	$this->middleware('superadmin');
    }

    public function index(Request $request){
    	return view('superadmin.users.index')->with('users', User::where('level', "<=", $this->user()->level)->get());
    }

    public function singleuser(User $user, Request $request){

      $userCompanyId = $user['company_id'];
      $companySection = Company::whereId($user['company_id'])->first();
      //echo '<pre>';  print_r($user['company_id']); echo '</pre>';
      //echo '<pre>';  print_r($companySection->sections); echo '</pre>';
      //Sections::get();
    //  return view('superadmin.users.user')->with('user', $user)->with('sections', Sections::get()); COMMENTED on 28 march 2019 by manvendra
    	return view('superadmin.users.user')->with('user', $user)->with('sections', $companySection->sections);
    }

    public function section(User $user, Request $request){
    	$user->sections()->sync($request->get('sections', []) ?: []);
    	if($request->ajax()){
    		return response()->json(['status'=> "Successfully assigned section"]);
    	}else{
        return redirect()->route('superadmin.users.index')->with('status', "Successfully assigned section");
    	//	return redirect()->back()->with('status', "Successfully assigned section");
    	}
    }

    public function activatedeactivate(User $user, Request $request){
    	$user->level = $request->get('level', 0) ?: 0;
    	if($user->save()){
	    	if($request->ajax()){
	    		return response()->json(['status'=> "Successfully changed Status"]);
	    	}else{
    			return redirect()->back()->with('status', 'Successfully changed Status');
	    	}
    	}
    	if($request->ajax()){
    		return response()->json(['status'=> "Unable to change status"]);
    	}else{
    		return redirect()->back()->with('error', 'Unable to change status');
    	}
    }

    public function user(){
    	return Auth::user();
    }
}
