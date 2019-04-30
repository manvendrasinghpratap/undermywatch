<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Stats;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
class AdminController extends Controller 
{
    //
    public function __construct(){
    	$this->middleware('auth');
      $this->middleware('user');
      //$this->middleware(['auth','user','admin']);
    }

    public function index(){
      $users = User::whereCompanyId(Auth::user()->company_id)->whereLevel(config('app.userlevel'))->get();
      return view('user.users.index')->with('users',$users);
    }
    public function home(Request $request){
      $date = Carbon::today()->subDays(7)->format('Y-m-d');
      $statisticsBlocked = Stats::where('user_id',Auth::user()->id)->where('is_safe',1)->whereDate('created_at', '>=', Carbon::now()->subDays(7))->count();
      $statisticsPassed = Stats::where('user_id',Auth::user()->id)->where('is_safe',0)->whereDate('created_at', '>=', Carbon::now()->subDays(7))->count();
      $activeLinks = Stats::where('user_id',Auth::user()->id)->whereDate('updated_at', '>=', Carbon::now()->subDays(7))->groupBy('link_id')->get();
      $activeLinksCount = $activeLinks->count();
      $statisticsRecordsGroupBy = Stats::select(DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'),DB::raw('DATE(created_at) as date'),'user_id','is_safe','link_id','id')->where('user_id',Auth::user()->id)->whereDate('created_at', '>=', Carbon::now()->subDays(7)->format('Y-m-d'))->groupBy('date')->get();
      $statisticsRecordsGroupBy = $statisticsRecordsGroupBy->toArray();
      //$blockedArray = array('3','6','7','8','4','20','20');
      $passedArray  = array(0,0,0,0,0,0,0);
      $blockedArray = array(0,0,0,0,0,0,0);
      //$blockedArray = '3,6,7,8,4,20,20';

      if(count($statisticsRecordsGroupBy)>0){
        $passedArray = array();
        $blockedArray = array();
        foreach($statisticsRecordsGroupBy as $data){
          if($data['is_safe']==1){
            $blockedArray[$data['id']] = $data['safe'];
          }
          if($data['is_safe']==0){
            $passedArray[$data['id']] = $data['safe'];
          }

        }
      }
    $implodeBlockedData = implode(',',$blockedArray);
    $implodePassedData = implode(',',$passedArray);
    $stats = Stats::where('user_id',Auth::user()->id)
                ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                ->select(DB::raw('DATE(created_at) as date'))
                ->selectRaw('count(*) as clicks, is_safe')
                ->groupBy('date') ->groupBy('is_safe')
                ->orderBy('date', "ASC")->get();

          $gStats = [];
          foreach($stats as $_s){
            if(empty($gStats[$_s->date])){
              $gStats[$_s->date]['blocked'] = 0;
              $gStats[$_s->date]['passed'] = 0;
              $gStats[$_s->date]['total'] = 0;
            }
            if($_s->is_safe == 1){
              $gStats[$_s->date]['blocked'] = $_s->clicks;
              $gStats[$_s->date]['total'] = $gStats[$_s->date]['total'] + $_s->clicks;
            }else{
              $gStats[$_s->date]['passed'] = $_s->clicks;
              $gStats[$_s->date]['total'] = $gStats[$_s->date]['total'] + $_s->clicks;
            }
          }
    	return view('user.home')->with('user', $this->user())->with('statisticsBlocked',$statisticsBlocked)->with('statisticsPassed',$statisticsPassed)->with('activeLinksCount',$activeLinksCount)->with('blockedClick',$implodeBlockedData)->with('passedClick',$implodePassedData)->with('gStats', $gStats);
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
