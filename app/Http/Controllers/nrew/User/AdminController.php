<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
      $this->middleware('user');
      //$this->middleware(['auth','user','admin']);
    }

    public function index(){

      $users = User::whereCompanyId(Auth::user()->company_id)->whereLevel(3)->get();
      return view('user.users.index')->with('users',$users);
    }
    public function home(Request $request){
    	return view('user.home')->with('user', $this->user());
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
      $userdata->level = 3;
      $userdata->company_id = Auth::user()->company_id;
      $userdata->password = Hash::make($request->password);
      $userdata->save();
      return redirect()->route('user.users.index')->with('success', 'User created successfully.');
    }
    public function create()
    {
      return view('user.users.create');
    }

    public function destroy(Request $request,$id)
    {
       $id = base64_decode($id);
       User::where('id',  $id)
               ->update(['level' => 0,'deleted_at'=>date('Y-m-d G:i:s')]);
       if($request->ajax()){
           return response()->json(['status' => "User Deleted Successfully"]);
       }else{
         \Session::put(['status' => 'User Deleted Successfully']);
           return redirect()->back();
       }
    }
}
