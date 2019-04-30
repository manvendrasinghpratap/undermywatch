<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Sections;

class UsersManager extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('admin');
    }

    public function index(Request $request){
    	return view('superadmin.users.index')->with('users', User::where('level', "<=", $this->user()->level)->get());
    }

    public function singleuser(User $user, Request $request){
    	return view('admin.users.assignsectiontouser')->with('user', $user)->with('sections', Auth::user()->companyname->sections);
    }

    public function section(User $user, Request $request){
    	$user->sections()->sync($request->get('sections', []) ?: []);
    	if($request->ajax()){
    		return response()->json(['status'=> "Successfully assigned section"]);
    	}else{
    		return redirect()->back()->with('status', "Successfully assigned section");
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
