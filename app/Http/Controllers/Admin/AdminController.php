<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Sections;
use App\Domains;
use App\Company;
use App\Stats;
use App\Links;
use App\User;
use Auth;
use DB;
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

      $users = User::whereCompanyId(Auth::user()->company_id)->whereIn('level',[config('app.userlevel'),config('app.adminlevel')])->get();
      return view('admin.users.index')->with('users',$users);
    }

  /*  public function admindashboard(Request $request){
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
*/

        public function admindashboard(Request $request){
          Auth::user()->company_id;
          $companyData = Company::whereId(Auth::user()->company_id)->first();
          //$this->pp($companyData,0);
          $date = Carbon::today()->subDays(7)->format('Y-m-d');
          $statisticsBlocked = Stats::where('company_id',Auth::user()->company_id)->where('is_safe',1)->whereDate('created_at', '>=', Carbon::now()->subDays(7))->count();
          $statisticsPassed = Stats::where('company_id',Auth::user()->company_id)->where('is_safe',0)->whereDate('created_at', '>=', Carbon::now()->subDays(7))->count();
          $activeLinks = Stats::where('company_id',Auth::user()->company_id)->whereDate('updated_at', '>=', Carbon::now()->subDays(7))->groupBy('link_id')->get();
          $activeLinksCount = $activeLinks->count();
          $statisticsRecordsGroupBy = Stats::select(DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'),DB::raw('DATE(created_at) as date'),'user_id','is_safe','link_id','id')->where('company_id',Auth::user()->company_id)->whereDate('created_at', '>=', Carbon::now()->subDays(7)->format('Y-m-d'))->groupBy('date')->get();
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
            $stats = Stats::where('company_id',Auth::user()->company_id)
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


          return view('admin.admindashboard')->with('user', $this->user())->with('statisticsBlocked',$statisticsBlocked)->with('statisticsPassed',$statisticsPassed)->with('activeLinksCount',$activeLinksCount)->with('blockedClick',$implodeBlockedData)->with('passedClick',$implodePassedData)->with('gStats', $gStats)->with('companyData',$companyData);
        }


    public function home(Request $request){
      Auth::user()->company_id;
      $sectionData = Sections::get();
      $date = Carbon::today()->subDays(7)->format('Y-m-d');
      $statisticsBlocked = Stats::where('is_safe',1)->whereDate('created_at', '>=', Carbon::now()->subDays(70))->count();

      //$this->pp($statisticsBlocked,0);
      $statisticsPassed = Stats::where('is_safe',0)->whereDate('created_at', '>=', Carbon::now()->subDays(70))->count();
    //  $this->pp($statisticsPassed,0);


      $activeLinks = Stats::whereDate('updated_at', '>=', Carbon::now()->subDays(70))->groupBy('link_id')->get();

      $activeLinksCount = $activeLinks->count();
      //$this->pp($activeLinksCount,0);
      $statisticsRecordsGroupBy = Stats::select(DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'),DB::raw('DATE(created_at) as date'),'user_id','is_safe','link_id','id')->whereDate('created_at', '>=', Carbon::now()->subDays(70)->format('Y-m-d'))->groupBy('date')->get();
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
        $stats = Stats::whereDate('created_at', '>=', Carbon::now()->subDays(70))
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


      return view('admin.home')->with('user', $this->user())->with('statisticsBlocked',$statisticsBlocked)->with('statisticsPassed',$statisticsPassed)->with('activeLinksCount',$activeLinksCount)->with('blockedClick',$implodeBlockedData)->with('passedClick',$implodePassedData)->with('gStats', $gStats)->with('sectionData',$sectionData);
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
