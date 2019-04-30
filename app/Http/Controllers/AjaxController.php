<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Common;
use DB;
use Session;
use Config;
use Carbon\Carbon;
use App\User;


class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(){
      $this->middleware('auth');
     }
    public function index()
    {
        //
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
    public function destroy($tableName,$id,$deletetype)
    {
        if(!empty(Config::get('app.mysql_table_prefix'))){
            //$tableName  =   Config::get('app.mysql_table_prefix').$tableName;
        }
        if($deletetype=='softdelete')
            echo $status = DB::table($tableName)->where('id','=',$id)->update(['deleted_at' => Carbon::now()]);
          else
            echo $status = DB::table($tableName)->where('id','=',$id)->delete();

    }
    public function destroyByCustomColumn($tableName,$id,$columnName)
    {
        echo $status = DB::table($tableName)->where($columnName,'=',$id)->delete();
    }

    public function changepassword(Request $request)
    {
      if(!empty($request->userid))
      {
        $user = User::find($request->userid);
        $user->password = Hash::make($request->password);
        $user->save();
        echo '1';
      }
      else
        echo '0';
      // code...
    }

    public function changeuserlevel(Request $request)
    {
      //$this->PP($request->all(),1);
      $newData = array();
      if(!empty($request->userid))
      {
        if($request->currentlevel=='user'){
          $level = config('app.adminlevel');
          $newData['newlevel'] = 'admin';
        }elseif($request->currentlevel=='admin'){
          $level = config('app.userlevel');
          $newData['newlevel'] = 'user';
        }
        $user = User::find($request->userid);
        $user->level = $level;
        $user->save();
        echo json_encode($newData);
      }
      else
        echo json_encode($newData);
      // code...
    }

    public function changeuserstatus(Request $request)
    {
      if(!empty($request->userid))
      {
        if($request->userStatus=='0'){
          $status = 1;
        }elseif($request->userStatus=='1'){
          $status = 0;
        }
        $user = User::find($request->userid);
        $user->status = $status;
        $user->save();
        echo '1';
      }
      else
        echo '0';
    }


}
